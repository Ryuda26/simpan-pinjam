<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

// Autentikasi (hanya untuk tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Halaman yang wajib login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('members', MemberController::class);
    Route::resource('transactions', TransactionController::class)->except('show');

    // Laporan PDF (FPDF)
    Route::get('/laporan/anggota', [ReportController::class, 'anggota'])->name('laporan.anggota');
    Route::get('/laporan/transaksi', [ReportController::class, 'transaksi'])->name('laporan.transaksi');
    Route::get('/laporan/lengkap', [ReportController::class, 'lengkap'])->name('laporan.lengkap');
});
