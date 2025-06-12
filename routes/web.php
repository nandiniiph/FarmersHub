<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajemenProdukController;
use App\Http\Controllers\ManajemenAkunController;

Route::get('/', function () {
    return view('LandingPage');
});

Route::get('/Login', [LoginController::class, 'showLogin'])->name('showLogin');
Route::post('/proses-Login', [LoginController::class, 'login'])->name('login');
Route::get('/Register', [LoginController::class, 'showRegister'])->name('showRegister');
Route::post('/proses-Register', [LoginController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/DashboardAdmin', [LoginController::class, 'showDashboardAdmin'])->name('showDashboardAdmin');
Route::get('/DashboardKonsumen', [LoginController::class, 'showDashboardKonsumen'])->name('showDashboardKonsumen');
Route::get('/DashboardPetani', [LoginController::class, 'showDashboardPetani'])->name('showDashboardPetani');

Route::get('/Profile', [ManajemenAkunController::class, 'profile'])->middleware('auth')->name('profile.index');

Route::get('/produk/index', [ManajemenProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/tambahProduk', [ManajemenProdukController::class, 'create'])->name('produk.create');
Route::post('/produk/simpanProduk', [ManajemenProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/editProduk/{id}', [ManajemenProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/updateProduk/{id}', [ManajemenProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/hapusProduk/{id}', [ManajemenProdukController::class, 'destroy'])->name('produk.destroy');

Route::get('/akun-petani', function () {
    return 'Halaman Akun Petani';
})->name('akun.petani');

Route::get('/penjualan', function () {
    return 'Halaman Penjualan';
})->name('penjualan.index');

Route::get('/riwayat', function () {
    return 'Halaman Riwayat';
})->name('riwayat.index');

Route::get('/pesanan', function () {
    return 'Halaman Pesanan';
})->name('pesanan.index');
