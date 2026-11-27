<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman Awal langsung menuju Login (atau Beranda/Dashboard jika sudah masuk)
Route::get('/', function () {
    if (Auth::check()) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isAdmin() && Route::has('admin.dashboard')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('beranda');
    }

    return redirect()->route('login');
})->name('landing');

// Katalog Publik Barang Hilang & Ditemukan (Mahasiswa / Pengguna)
Route::get('/beranda', [BarangController::class, 'index'])->name('beranda');

// Detail Barang (publik)
Route::get('/barangs/{barang}', [BarangController::class, 'show'])->name('barangs.show');

// Redirect Dashboard berdasarkan Role
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->isAdmin() && Route::has('admin.dashboard')) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('beranda');
})->middleware(['auth', 'verified'])->name('dashboard');

// Fitur Khusus Pengguna Terdaftar (Mahasiswa & Admin)
Route::middleware('auth')->group(function () {
    // Form Pelaporan Baru
    Route::get('/lapor', [BarangController::class, 'create'])->name('barangs.create');
    Route::post('/lapor', [BarangController::class, 'store'])->name('barangs.store');

    // Riwayat Laporan Milik Pengguna
    Route::get('/laporan-saya', [BarangController::class, 'myReports'])->name('barangs.my');

    // Edit & Hapus Laporan
    Route::get('/barangs/{barang}/edit', [BarangController::class, 'edit'])->name('barangs.edit');
    Route::put('/barangs/{barang}', [BarangController::class, 'update'])->name('barangs.update');
    Route::delete('/barangs/{barang}', [BarangController::class, 'destroy'])->name('barangs.destroy');

    // Ubah Status Cepat (misal selesai / klaim)
    Route::patch('/barangs/{barang}/status', [BarangController::class, 'updateStatus'])->name('barangs.status');

    // Profil Akun
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Rute Admin dipisah agar tidak ikut aktif saat deployment publik (ADMIN_ENABLED=false)
if (config('app.admin_enabled', true) && file_exists(__DIR__.'/admin.php')) {
    require __DIR__.'/admin.php';
}
