<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\DetailKeranjang;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // Halaman daftar semua transaksi user
    public function index()
    {
        $transaksi = Transaksi::with('detailTransaksi.produk')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('transaksi.show', compact('transaksi'));
    }

    // Proses checkout
    public function checkout(Request $request)
    {
        $user = Auth::user();

        // Validasi minimal satu produk dipilih
        $request->validate([
            'produk_terpilih' => 'required|array|min:1'
        ]);

        // Ambil data keranjang
        $keranjang = Keranjang::where('user_id', $user->user_id)->first();

        if (!$keranjang) {
            return redirect()->back()->with('error', 'Keranjang tidak ditemukan.');
        }

        $total = 0;

        // Hitung total dan simpan detail transaksi
        $transaksi = Transaksi::create([
            'user_id' => $user->user_id,
            'tanggal_transaksi' => now(),
            'total_harga' => 0,
            'status' => 'Pending',
        ]);

        foreach ($request->produk_terpilih as $detailId) {
            $detail = DetailKeranjang::find($detailId);
            if ($detail) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->transaksi_id,
                    'product_id' => $detail->product_id,
                    'jumlah' => $detail->jumlah,
                    'harga_satuan' => $detail->Produk->harga,
                ]);
                $total += $detail->jumlah * $detail->Produk->harga;

                // Hapus dari keranjang
                $detail->delete();
            }
        }

        $transaksi->update(['total_harga' => $total]);

        return redirect()->route('transaksi.show', $transaksi->transaksi_id)
                        ->with('success', 'Checkout berhasil!');
    }

    // Pesanan yang sedang aktif
    public function pesanan()
    {
        $transaksi = Transaksi::with('detailTransaksi.produk')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['Pending', 'Lunas', 'Batal'])
            ->orderByDesc('created_at')
            ->get();

        return view('transaksi.pesanan', compact('transaksi'));
    }

    // Riwayat transaksi selesai
    public function riwayat()
    {
        $transaksi = Transaksi::with('detailTransaksi.produk')
            ->where('user_id', Auth::id())
            ->where('status', 'Selesai')
            ->orderByDesc('created_at')
            ->get();

        return view('transaksi.riwayat', compact('transaksi'));
    }

    // Detail transaksi tertentu
    public function show($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.produk')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $role = Auth::user()->role;

        $layout = $role === 'petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('transaksi.show', compact('transaksi', 'layout'));
    }
}
