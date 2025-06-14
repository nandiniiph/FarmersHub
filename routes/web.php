<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajemenProdukController;
use App\Http\Controllers\ManajemenAkunController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UpgradeController;
use App\Http\Controllers\ProfilController;

Route::get('/', fn() => view('LandingPage'));

// Auth
Route::get('/Login', [LoginController::class, 'showLogin'])->name('showLogin');
Route::post('/proses-Login', [LoginController::class, 'login'])->name('login');
Route::get('/Register', [LoginController::class, 'showRegister'])->name('showRegister');
Route::post('/proses-Register', [LoginController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/DashboardAdmin', [LoginController::class, 'showDashboardAdmin'])->name('showDashboardAdmin');
Route::get('/DashboardKonsumen', [LoginController::class, 'showDashboardKonsumen'])->name('showDashboardKonsumen');
Route::get('/DashboardPetani', [LoginController::class, 'showDashboardPetani'])->name('showDashboardPetani');

// Dashboard dinamis sesuai peran
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('showLogin');
    }

    return match ($user->role) {
        'Admin' => redirect()->route('showDashboardAdmin'),
        'Petani' => redirect()->route('showDashboardPetani'),
        default => redirect()->route('showDashboardKonsumen'),
    };
})->middleware('auth')->name('dashboard');


// Profil
Route::get('/profil', [ManajemenAkunController::class, 'profil'])->middleware('auth')->name('profil.index');
Route::get('/EditProfil', [ManajemenAkunController::class, 'showEditProfil'])->name('showEditProfil');
Route::post('/proses-EditProfil', [ManajemenAkunController::class, 'updateProfil'])->name('updateProfil');

// Produk (Petani)
Route::prefix('produk')->group(function () {
    Route::get('/index', [ManajemenProdukController::class, 'index'])->name('produk.index');
    Route::get('/tambahProduk', [ManajemenProdukController::class, 'create'])->name('produk.create');
    Route::post('/simpanProduk', [ManajemenProdukController::class, 'store'])->name('produk.store');
    Route::get('/editProduk/{id}', [ManajemenProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/updateProduk/{id}', [ManajemenProdukController::class, 'update'])->name('produk.update');
    Route::delete('/hapusProduk/{id}', [ManajemenProdukController::class, 'destroy'])->name('produk.destroy');
});

// Belanja & Keranjang
Route::get('/belanja', [BelanjaController::class, 'index'])->name('belanja.index');
Route::post('/keranjang/tambah/{product_id}', [BelanjaController::class, 'tambahKeranjang'])->name('keranjang.tambah');
Route::get('/keranjang', [BelanjaController::class, 'lihatKeranjang'])->name('keranjang.lihat');
Route::delete('/keranjang/hapus/{id}', [BelanjaController::class, 'hapusItem'])->name('keranjang.hapus');


// Transaksi: Checkout, Pesanan, dan Riwayat
Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
Route::get('/pesanan', [TransaksiController::class, 'pesanan'])->name('transaksi.pesanan');
Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');

// Fitur tambahan
Route::get('/upgrade', [UpgradeController::class, 'index'])->name('upgrade.index');

