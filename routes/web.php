<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProfileController;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman Utama Landing Page (User-Centric Portal)
Route::get('/', function () {
    $barangsTerbaru = Barang::with('user')->latest()->take(6)->get();
    $totalHilang = Barang::where('jenis', 'hilang')->where('status', '!=', 'selesai')->count();
    $totalTemuan = Barang::where('jenis', 'ditemukan')->where('status', '!=', 'selesai')->count();
    $totalSelesai = Barang::where('status', 'selesai')->count();

    return view('landing', compact('barangsTerbaru', 'totalHilang', 'totalTemuan', 'totalSelesai'));
})->name('landing');

// Katalog Publik Barang Hilang & Ditemukan
Route::get('/beranda', [BarangController::class, 'index'])->name('beranda');

// Detail Barang (publik)
Route::get('/barangs/{barang}', [BarangController::class, 'show'])->name('barangs.show');

// Redirect Dashboard berdasarkan Role (Khusus Admin ke Panel Admin, Mahasiswa langsung ke Beranda)
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('beranda');
})->middleware(['auth', 'verified'])->name('dashboard');

// Fitur Khusus Pengguna Terdaftar (Mahasiswa & Admin)
Route::middleware('auth')->group(function () {
    // Form Pelaporan Baru
    Route::get('/lapor', [BarangController::class, 'create'])->name('barangs.create');
    Route::post('/lapor', [BarangController::class, 'store'])->name('barangs.store');

    // Riwayat Laporan Milik Pengguna (atau Semua Laporan jika Admin)
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

// Panel Khusus Administrator Kampus (Dilindungi Middleware Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::patch('/barangs/{barang}/verify', [AdminController::class, 'verify'])->name('barangs.verify');
    Route::patch('/barangs/{barang}/complete', [AdminController::class, 'complete'])->name('barangs.complete');
    Route::delete('/barangs/{barang}', [AdminController::class, 'destroy'])->name('barangs.destroy');
});

require __DIR__.'/auth.php';
