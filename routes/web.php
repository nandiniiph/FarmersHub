<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManajemenProdukController;


Route::get('/', function () {
    return view('LandingPage');
});

Route::get('/Login', [LoginController::class, 'showLogin'])->name('showLogin');
Route::post('/proses-Login', [LoginController::class, 'login'])->name('login');
Route::get('/Register', [LoginController::class, 'showRegister'])->name('showRegister');
Route::post('/proses-Register', [LoginController::class, 'register'])->name('register');
Route::get('/DashboardAdmin', [LoginController::class, 'showDashboardAdmin'])->name('showDashboardAdmin');
Route::get('/DashboardKonsumen', [LoginController::class, 'showDashboardKonsumen'])->name('showDashboardKonsumen');
Route::get('/DashboardPetani', [LoginController::class, 'showDashboardPetani'])->name('showDashboardPetani');
Route::resource('produk', ManajemenProdukController::class);

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
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


