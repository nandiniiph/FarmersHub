<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\DetailKeranjang;

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
        $selected = $request->input('produk_terpilih', []);

        if (empty($selected)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih.');
        }

        $detailKeranjang = DetailKeranjang::whereIn('detail_keranjang_id', $selected)
                                          ->with('Produk')
                                          ->get();

        $total = 0;
        foreach ($detailKeranjang as $item) {
            $total += $item->jumlah * $item->Produk->harga;
        }

        $transaksi = Transaksi::create([
            'user_id' => $userId,
            'status' => 'Pending',
            'total_harga' => $total,
            'tanggal_transaksi' => now(),
        ]);

        foreach ($detailKeranjang as $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->transaksi_id,
                'product_id' => $item->product_id,
                'jumlah' => $item->jumlah,
                'harga_satuan' => $item->Produk->harga,
            ]);

            $item->delete();
        }

        return redirect()->route('transaksi.show', $transaksi->transaksi_id)
                         ->with('success', 'Checkout berhasil!');
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
        $transaksi = Transaksi::withCount('DetailTransaksi')
                        ->where('user_id', $user->user_id)
                        ->where('status', 'Pending')
                        ->orderBy('created_at', 'desc')
                        ->get();

        $layout = $user->role === 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('transaksi.pesanan_saya', compact('transaksi', 'layout'));
    }

    public function riwayat()
    {
        $user = Auth::user();

        $transaksiList = Transaksi::withCount('detailTransaksi')
            ->where('user_id', $user->user_id)
            ->whereIn('status', ['Lunas', 'Batal'])
            ->orderByDesc('created_at')
            ->get();

        $layout = $user->role === 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('transaksi.riwayat', compact('transaksiList', 'layout'));
    }

}
