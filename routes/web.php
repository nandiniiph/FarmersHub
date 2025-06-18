<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajemenProdukController;
use App\Http\Controllers\ManajemenAkunController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UpgradeController;
use App\Http\Controllers\PesananPetaniController;
use Illuminate\Support\Facades\Auth;

Route::get('/', fn() => view('LandingPage'));

//  AUTH
Route::get('/Login', [LoginController::class, 'showLogin'])->name('showLogin');
Route::post('/proses-Login', [LoginController::class, 'login'])->name('login');
Route::get('/Register', [LoginController::class, 'showRegister'])->name('showRegister');
Route::post('/proses-Register', [LoginController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//  DASHBOARD  SESUAI ROLE
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) return redirect()->route('showLogin');

    return match ($user->role) {
        'Admin' => redirect()->route('showDashboardAdmin'),
        default => redirect()->route('belanja.index'),
    };
})->middleware('auth')->name('dashboard');

//  KHUSUS ADMIN
Route::get('/DashboardAdmin', [LoginController::class, 'showDashboardAdmin'])
    ->middleware('auth')->name('showDashboardAdmin');

//  BELANJA (DASHBOARD UTAMA)
Route::get('/DashboardPetani', [BelanjaController::class, 'index'])
    ->middleware('auth')->name('showDashboardPetani');
Route::get('/DashboardKonsumen', [BelanjaController::class, 'index'])
    ->middleware('auth')->name('showDashboardKonsumen');

Route::middleware('auth')->group(function () {
    //  Profil
    Route::get('/profil', [ManajemenAkunController::class, 'profil'])->name('profil.index');
    Route::get('/EditProfil', [ManajemenAkunController::class, 'showEditProfil'])->name('showEditProfil');
    Route::post('/proses-EditProfil', [ManajemenAkunController::class, 'updateProfil'])->name('updateProfil');
    Route::get('/IsiSaldo', [ManajemenAkunController::class, 'showIsiSaldo'])->name('showIsiSaldo');
    Route::post('/Tambah-saldo', [ManajemenAkunController::class, 'storeSaldo'])->name('storeSaldo');

    //  Produk (Petani)
    Route::prefix('produk')->group(function () {
        Route::get('/index', [ManajemenProdukController::class, 'index'])->name('produk.index');
        Route::get('/tambahProduk', [ManajemenProdukController::class, 'create'])->name('produk.create');
        Route::post('/simpanProduk', [ManajemenProdukController::class, 'store'])->name('produk.store');
        Route::get('/editProduk/{id}', [ManajemenProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/updateProduk/{id}', [ManajemenProdukController::class, 'update'])->name('produk.update');
        Route::delete('/hapusProduk/{id}', [ManajemenProdukController::class, 'destroy'])->name('produk.destroy');
    });

    //  Belanja & Keranjang
    Route::get('/belanja', [BelanjaController::class, 'index'])->name('belanja.index');
    Route::post('/keranjang/tambah/{product_id}', [BelanjaController::class, 'tambahKeranjang'])->name('keranjang.tambah');
    Route::get('/keranjang', [BelanjaController::class, 'lihatKeranjang'])->name('keranjang.lihat');
    Route::post('/keranjang/update-jumlah/{id}', [BelanjaController::class, 'updateJumlah'])->name('keranjang.updateJumlah');
    Route::delete('/keranjang/hapus/{id}', [BelanjaController::class, 'hapusItem'])->name('keranjang.hapus');

    //  Transaksi
    Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/multiple/{ids}', [TransaksiController::class, 'tampilkanBeberapaTransaksi'])->name('transaksi.multiple');
    Route::get('/pesanan', [TransaksiController::class, 'pesananSaya'])->name('pesanan.saya');
    Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
    Route::post('/transaksi/{id}/bayar', [TransaksiController::class, 'konfirmasiBayar'])->name('transaksi.bayar');
    Route::put('/transaksi/{id}/batal', [TransaksiController::class, 'batalkan'])->name('transaksi.batal');
    Route::post('/transaksi/konfirmasi-selesai/{id}', [TransaksiController::class, 'konfirmasiSelesai'])->name('transaksi.konfirmasiSelesai');
    Route::post('/transaksi/pesanan-diterima/{id}', [TransaksiController::class, 'pesananDiterima'])->name('transaksi.pesananDiterima');
    Route::middleware(['auth'])->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'lihatSemua'])->name('transaksi.semua');
    });

    // Upgrade Akun
    Route::get('/PengajuanUpgrade', [UpgradeController::class, 'showTambahUpgrade'])->name('showTambahUpgrade');
    Route::get('/KonfirmasiUpgrade', [UpgradeController::class, 'index'])->name('upgrade.index');
    Route::post('/tambahUpgrade', [UpgradeController::class, 'createPengajuan'])->name('createPengajuan');
    Route::post('/permohonan/setujui/{id}', [UpgradeController::class, 'SetujuiPermohonan'])->name('SetujuiPermohonan');
    Route::get('/upgrade/update/{id}', [UpgradeController::class, 'showUpdateUpgrade'])->name('showUpdateUpgrade');
    Route::post('/permohonan/tolak/{id}', [UpgradeController::class, 'TolakPermohonan'])->name('TolakPermohonan');

    // Manajemen Akun (Admin)
    Route::get('/akun', [ManajemenAkunController::class, 'showAkun'])->name('akun.index');
    Route::get('/akunFilter', [ManajemenAkunController::class, 'FilterAkun'])->name('FilterAkun');
    Route::post('/akun/{id}/delete', [ManajemenAkunController::class, 'HapusAkun'])->name('HapusAkun');

    //  Pesanan Masuk
    Route::get('/pesanan-masuk', [PesananPetaniController::class, 'pesananMasuk'])->name('pesanan.masuk');
    Route::post('/transaksi/update-status/{id}', [PesananPetaniController::class, 'updateStatus'])->name('transaksi.updateStatus');
    Route::get('/transaksi/invoice/{id}', [PesananPetaniController::class, 'invoice'])->name('transaksi.invoice');}
);
