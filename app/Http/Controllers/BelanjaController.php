<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\DetailKeranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BelanjaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $produk = $user->role == 'Petani'
            ? Produk::where('user_id', '!=', $user->user_id)->get()
            : Produk::all();
        $layout = Auth::user()->role == 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('belanja.index', compact('produk', 'layout'));
    }

    public function lihatKeranjang()
    {
        $keranjang = Keranjang::with('DetailKeranjang.Produk')
            ->where('user_id', auth()->id())
            ->first(); // atau ->latest()->first() jika bisa banyak
        $layout = Auth::user()->role == 'Petani' ? 'layouts.appPetani' : 'layouts.appKonsumen';

        return view('keranjang.index', compact('keranjang', 'layout'));
    }


    public function tambahKeranjang(Request $request, $product_id)
    {
        $userId = Auth::id();

        $keranjang = Keranjang::firstOrCreate(
            ['user_id' => $userId]
        );

        $detail = DetailKeranjang::where('cart_id', $keranjang->cart_id)
                    ->where('product_id', $product_id)
                    ->first();

        if ($detail) {
            $detail->jumlah += $request->input('jumlah', 1);
            $detail->save();
        } else {
            DetailKeranjang::create([
                'cart_id' => $keranjang->cart_id,
                'product_id' => $product_id,
                'jumlah' => $request->input('jumlah', 1),
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function hapusItem($id)
    {
        $item = DetailKeranjang::with('Keranjang')->findOrFail($id);
        if (auth()->id() === $item->Keranjang->user_id) {
            $item->delete();
            return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Akses ditolak.');
    }

}
