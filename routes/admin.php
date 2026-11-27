<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Autentikasi Khusus Administrator Kampus (Terpisah dari Mahasiswa)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('/admin/login', [AdminAuthenticatedSessionController::class, 'store'])
        ->name('admin.login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [AdminAuthenticatedSessionController::class, 'destroy'])
        ->name('admin.logout');
});

// Panel Khusus Administrator Kampus (Dilindungi Middleware Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::patch('/barangs/{barang}/verify', [AdminController::class, 'verify'])->name('barangs.verify');
    Route::patch('/barangs/{barang}/complete', [AdminController::class, 'complete'])->name('barangs.complete');
    Route::delete('/barangs/{barang}', [AdminController::class, 'destroy'])->name('barangs.destroy');
});
