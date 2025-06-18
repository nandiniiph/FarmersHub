<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\DetailKeranjang;
use App\Models\Produk;

class TransaksiController extends Controller
{
    public function show($id)
    {
        $transaksi = Transaksi::with(['DetailTransaksi.Produk', 'User'])->findOrFail($id);
        $user = Auth::user();
        $layout = $user->role === 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('transaksi.show', compact('transaksi', 'layout'));
    }

    public function tampilkanBeberapaTransaksi($ids)
    {
        $idArray = explode(',', $ids);
        $transaksis = Transaksi::whereIn('transaksi_id', $idArray)->with('detailTransaksi.produk')->get();
        $user = Auth::user();
        $layout = $user->role === 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('transaksi.multiple', compact('transaksis', 'layout'));
    }

    public function lihatSemua()
    {
        $user = Auth::user();
        $layout = $user->role === 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        $transaksis = Transaksi::with(['detailTransaksi.produk', 'user'])
            ->where('user_id', $user->user_id)
            ->latest()
            ->get();

        return view('transaksi.multiple', compact('transaksis', 'layout'));
    }



    public function checkout(Request $request)
    {
        $userId = Auth::id();
        $checkoutFrom = $request->input('checkout_from');

        $items = [];

        if ($checkoutFrom === 'keranjang') {
            $selectedDetailIds = $request->input('produk_terpilih', []);

            if (empty($selectedDetailIds)) {
                return redirect()->back()->with('error', 'Tidak ada produk yang dipilih dari keranjang.');
            }

            foreach ($selectedDetailIds as $detailId) {
                $detail = DetailKeranjang::with('produk')->findOrFail($detailId);
                $produk = $detail->produk;
                $jumlahItem = $detail->jumlah;

                if ($produk->stok < $jumlahItem) {
                    return redirect()->back()->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi.');
                }

                $items[] = [
                    'product_id' => $produk->product_id,
                    'jumlah' => $jumlahItem,
                    'harga' => $produk->harga,
                    'owner_id' => $produk->user_id,
                    'detail_id' => $detail->detail_keranjang_id,
                ];
            }
        } else {
            $selected = $request->input('produk_terpilih', []);
            $jumlah = $request->input('jumlah', []);

            if (empty($selected) || count($selected) !== count($jumlah)) {
                return redirect()->back()->with('error', 'Data produk tidak valid.');
            }

            foreach ($selected as $i => $productId) {
                $produk = Produk::findOrFail($productId);
                $jumlahItem = (int) $jumlah[$i];

                if ($produk->stok < $jumlahItem) {
                    return redirect()->back()->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi.');
                }

                $items[] = [
                    'product_id' => $produk->product_id,
                    'jumlah' => $jumlahItem,
                    'harga' => $produk->harga,
                    'owner_id' => $produk->user_id,
                ];
            }
        }

        // Kelompokkan item berdasarkan pemilik produk
        $groupedByOwner = collect($items)->groupBy('owner_id');
        $createdTransactionIds = [];

        foreach ($groupedByOwner as $ownerId => $produkGroup) {
            $total = 0;
            foreach ($produkGroup as $produk) {
                $total += $produk['harga'] * $produk['jumlah'];
            }

            $transaksi = Transaksi::create([
                'user_id' => $userId,
                'status' => 'Pending',
                'total_harga' => $total,
                'tanggal_transaksi' => now(),
            ]);

            foreach ($produkGroup as $produk) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->transaksi_id,
                    'product_id' => $produk['product_id'],
                    'jumlah' => $produk['jumlah'],
                    'harga_satuan' => $produk['harga'],
                    'status' => 'Menunggu',
                ]);

                $produkModel = Produk::findOrFail($produk['product_id']);
                $produkModel->stok = max(0, $produkModel->stok - $produk['jumlah']);
                $produkModel->save();

                if (isset($produk['detail_id'])) {
                    DetailKeranjang::where('detail_keranjang_id', $produk['detail_id'])->delete();
                }
            }

            $createdTransactionIds[] = $transaksi->transaksi_id;
        }

        // Redirect sesuai jumlah transaksi
        if (count($createdTransactionIds) === 1) {
            return redirect()->route('transaksi.show', $createdTransactionIds[0])
                ->with('success', 'Checkout berhasil!');
        }

        return redirect()->route('transaksi.multiple', ['ids' => implode(',', $createdTransactionIds)])
            ->with('success', 'Checkout berhasil dari beberapa penjual!');
    }

    public function konfirmasiBayar(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:Transfer Bank,E-Wallet,COD',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status === 'Lunas') {
            return back()->with('error', 'Transaksi sudah dibayar.');
        }

        $transaksi->metode_pembayaran = $request->metode_pembayaran;
        $transaksi->status = 'Lunas';
        $transaksi->save();

        $user = Auth::user(); // ⬅️ Dideklarasikan di sini sebelum dipakai
        $userId = $user->user_id;

        // Cek apakah masih ada transaksi lain yang belum lunas
        $transaksiPending = Transaksi::where('user_id', $userId)
            ->where('status', '!=', 'Lunas')
            ->count();

        // Jika semua transaksi user sudah lunas, redirect ke halaman pesanan
        if ($transaksiPending === 0) {
            return redirect()->route('pesanan.index')->with('success', 'Semua transaksi telah dibayar.');
        }

        // Ambil semua transaksi user
        $semuaTransaksi = Transaksi::with(['detailTransaksi.produk', 'user'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        // Tentukan layout berdasarkan role
        $layout = $user->role === 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        // Tampilkan halaman transaksi dengan banyak transaksi
        return view('transaksi.multiple', [
            'transaksis' => $semuaTransaksi,
            'layout' => $layout,
        ])->with('success', 'Pembayaran berhasil untuk transaksi #' . $transaksi->transaksi_id);
    }



    public function batalkan($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if (in_array($transaksi->status, ['Pending', 'Menunggu Pembayaran'])) {
            $transaksi->status = 'Batal';
            $transaksi->save();

            return redirect()->route('transaksi.show', $id)->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->route('transaksi.show', $id)->with('error', 'Pesanan tidak dapat dibatalkan.');
    }

    public function pesananSaya()
    {
        $user = Auth::user();

        $transaksiList = Transaksi::with(['detailTransaksi' => function ($query) {
                $query->whereNotIn('status', ['Selesai', 'Batal']);
            }])
            ->where('user_id', $user->user_id)
            ->where('status', '!=', 'Batal')
            ->whereHas('detailTransaksi', function ($query) {
                $query->whereNotIn('status', ['Selesai', 'Batal']);
            })
            ->orderByDesc('created_at')
            ->get();

        $layout = $user->role === 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('transaksi.pesanan_saya', compact('transaksiList', 'layout'));
    }

    public function riwayat()
    {
        $user = Auth::user();

        $transaksiList = Transaksi::with(['detailTransaksi'])
            ->where('user_id', $user->user_id)
            ->where(function ($query) {
                $query->where('status', 'Batal')
                      ->orWhereHas('detailTransaksi', function ($q) {
                          $q->where('status', 'Selesai');
                      });
            })
            ->orderByDesc('created_at')
            ->get();

        $layout = $user->role === 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('transaksi.riwayat', compact('transaksiList', 'layout'));
    }

    public function konfirmasiSelesai($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        foreach ($transaksi->detailTransaksi as $item) {
            $item->status = 'Selesai';
            $item->save();
        }

        return redirect()->route('transaksi.riwayat')->with('success', 'Pesanan dikonfirmasi selesai.');
    }

    public function pesananDiterima($id)
    {
        $transaksi = Transaksi::with('detailTransaksi')->findOrFail($id);

        foreach ($transaksi->detailTransaksi as $detail) {
            if ($detail->status === 'Dikirim') {
                $detail->status = 'Selesai';
                $detail->save();
            }
        }

        return redirect()->route('transaksi.riwayat')->with('success', 'Pesanan telah diterima.');
    }
}
