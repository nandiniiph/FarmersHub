<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class PesananController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $pesanan = Transaksi::where('user_id', $userId)
                    ->orderBy('tanggal_transaksi', 'desc')
                    ->get();

        return view('pesanan.index', compact('pesanan'));
    }
}
