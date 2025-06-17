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

    public function checkout(Request $request)
    {
        $userId = Auth::id();
        $checkoutFrom = $request->input('checkout_from');

        if ($checkoutFrom === 'keranjang') {
            $selectedDetailIds = $request->input('produk_terpilih', []); // isinya detail_keranjang_id

            if (empty($selectedDetailIds)) {
                return redirect()->back()->with('error', 'Tidak ada produk yang dipilih dari keranjang.');
            }

            $total = 0;
            $items = [];

            foreach ($selectedDetailIds as $detailId) {
                $detail = DetailKeranjang::with('produk')->findOrFail($detailId);

                $produk = $detail->produk;
                $jumlahItem = $detail->jumlah;

                if ($produk->stok < $jumlahItem) {
                    return redirect()->back()->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi.');
                }

                $total += $produk->harga * $jumlahItem;

                $items[] = [
                    'product_id' => $produk->product_id,
                    'jumlah' => $jumlahItem,
                    'harga' => $produk->harga,
                    'detail_id' => $detail->detail_keranjang_id,
                ];
            }

            $transaksi = Transaksi::create([
                'user_id' => $userId,
                'status' => 'Pending',
                'total_harga' => $total,
                'tanggal_transaksi' => now(),
            ]);

            foreach ($items as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->transaksi_id,
                    'product_id' => $item['product_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'status' => 'Menunggu',
                ]);

                $produk = Produk::findOrFail($item['product_id']);
                $produk->stok = max(0, $produk->stok - $item['jumlah']);
                $produk->save();

                DetailKeranjang::where('detail_keranjang_id', $item['detail_id'])->delete();
            }

            return redirect()->route('transaksi.show', $transaksi->transaksi_id)
                ->with('success', 'Checkout berhasil dari keranjang!');
        }

        // ========== Checkout dari "Beli Sekarang" ==========
        $selected = $request->input('produk_terpilih', []);
        $jumlah = $request->input('jumlah', []);

        if (empty($selected)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih.');
        }

        if (count($selected) !== count($jumlah)) {
            return redirect()->back()->with('error', 'Data tidak valid.');
        }

        $total = 0;
        $items = [];

        foreach ($selected as $i => $productId) {
            $produk = Produk::findOrFail($productId);
            $jumlahItem = (int) $jumlah[$i];

            if ($produk->stok < $jumlahItem) {
                return redirect()->back()->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi.');
            }

            $total += $produk->harga * $jumlahItem;
            $items[] = [
                'product_id' => $productId,
                'jumlah' => $jumlahItem,
                'harga' => $produk->harga,
            ];
        }

        $transaksi = Transaksi::create([
            'user_id' => $userId,
            'status' => 'Pending',
            'total_harga' => $total,
            'tanggal_transaksi' => now(),
        ]);

        foreach ($items as $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->transaksi_id,
                'product_id' => $item['product_id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga'],
                'status' => 'Menunggu',
            ]);

            $produk = Produk::findOrFail($item['product_id']);
            $produk->stok = max(0, $produk->stok - $item['jumlah']);
            $produk->save();
        }

        return redirect()->route('transaksi.show', $transaksi->transaksi_id)
            ->with('success', 'Checkout berhasil dari Beli Sekarang!');
    }


    public function konfirmasiBayar(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:Transfer Bank,E-Wallet,COD',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->metode_pembayaran = $request->metode_pembayaran;
        $transaksi->status = 'Lunas';
        $transaksi->save();

        return redirect()->route('transaksi.show', $id)->with('success', 'Pembayaran berhasil dikonfirmasi.');
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
