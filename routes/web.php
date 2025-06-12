<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


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
