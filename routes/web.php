<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\PengelolaanController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\ProfileController as PetugasProfileController; // Import Controller untuk Profil Petugas
use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;

Route::get('/manajemen_buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/pinjam_kembali', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/permintaan_perpanjangan', [TransaksiController::class, 'perpanjangan'])->name('perpanjangan.index');
Route::get('/laporan-denda', [TransaksiController::class, 'laporanDenda'])->name('denda.index');
Route::post('/denda/export', [TransaksiController::class, 'exportDenda'])->name('denda.export');

Route::get('/manajemen-pengguna', [PengelolaanController::class, 'pengguna'])->name('pengelolaan.pengguna');
Route::get('/review-ulasan', [PengelolaanController::class, 'review'])->name('pengelolaan.review');

// Route untuk Pengaturan Profil (GET)
Route::get('/pengaturan-profil', [ProfilController::class, 'index'])->name('profil.index');

// Route untuk Update Profil (POST)
Route::post('/pengaturan-profil', [ProfilController::class, 'update'])->name('profil.update');

// Route untuk Logout (Biasanya menggunakan POST atau GET sederhana)
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); // Redirect ke halaman login
})->name('logout');

Route::get('/', function () {
    return view('index');
});

// Authentication (custom simple handlers)
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot password (lupa password)
Route::get('/password/forgot', [ForgotPasswordController::class, 'show'])->name('password.request');
Route::post('/password/forgot', [ForgotPasswordController::class, 'sendReset'])->name('password.email');
Route::get('/password/sent', [ForgotPasswordController::class, 'sent'])->name('password.sent');

// Endpoint to return today's pengunjung count (uses cache key 'pengunjung:YYYY-MM-DD')
Route::get('/pengunjung/hari-ini', function () {
    $key = 'pengunjung:' . date('Y-m-d');
    $count = \Illuminate\Support\Facades\Cache::get($key, 0);
    return response()->json(['count' => (int) $count]);
});

// Admin area (simple). Protected by auth; optionally use 'is_admin' middleware if registered.
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/petugas', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');
    Route::get('/pengunjung', [PengunjungDashboardController::class, 'index'])->name('pengunjung.dashboard');
    
    // Route untuk halaman profil petugas
    Route::get('/petugas/profile', [PetugasProfileController::class, 'index'])->name('petugas.profile');
    
    // Admin: view password reset requests submitted by users without email
    Route::get('/admin/password-requests', [\App\Http\Controllers\Admin\PasswordRequestsController::class, 'index'])->name('admin.password_requests');
});
