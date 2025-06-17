<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Keranjang;



class PesananPetaniController extends Controller
{
    public function pesananMasuk()
    {
        $userId = Auth::id(); // petani yang login

        $pesananMasuk = DetailTransaksi::with(['Transaksi', 'Produk'])
            ->whereHas('Produk', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->whereHas('Transaksi', function ($query) {
                $query->where('status', 'Lunas');
            })
            ->orderByDesc('created_at')
            ->get();

        $layout = Auth::user()->role === 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('petani.pesananMasuk', compact('pesananMasuk', 'layout'));
    }

    public function updateStatus(Request $request, $id)
    {
        $statusBaru = $request->input('status');

        $validStatus = ['Menunggu', 'Diproses', 'Dikirim', 'Selesai'];
        if (!in_array($statusBaru, $validStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $detail = DetailTransaksi::with('Produk')->findOrFail($id);

        if ($detail->Produk->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $detail->status = $statusBaru;
        $detail->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function invoice($id)
    {
        $transaksi = Transaksi::with(['User', 'DetailTransaksi.Produk'])->findOrFail($id);
        $layout = Auth::user()->role === 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('transaksi.invoice', compact('transaksi', 'layout'));
    }
}
