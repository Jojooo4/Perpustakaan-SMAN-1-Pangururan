<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;
use App\Http\Controllers\Pengunjung\ProfileController;


// PUBLIC ROUTES
Route::get('/', function () {
    return view('index');
});

// API: jumlah pengunjung login hari ini (dipakai oleh homepage fetch)
Route::get('/pengunjung/hari-ini', function() {
    try {
        $count = DB::table('view_total_login_hari_ini')->value('total_login_hari_ini');
        return response()->json(['count' => (int)($count ?? 0)]);
    } catch (\Throwable $e) {
        return response()->json(['count' => 0], 200);
    }
});

// AUTHENTICATION
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// FORGOT PASSWORD
Route::get('/password/forgot', [ForgotPasswordController::class, 'show'])->name('password.request');
Route::post('/password/forgot', [ForgotPasswordController::class, 'sendReset'])->name('password.email');
Route::get('/password/sent', [ForgotPasswordController::class, 'sent'])->name('password.sent');

// ============================================
// PROTECTED ROUTES (AUTH)
// ============================================
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    
    // ========== ADMIN ROUTES ==========
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/petugas', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');
    Route::get('/pengunjung', [PengunjungDashboardController::class, 'index'])->name('pengunjung.dashboard');
    Route::get('/pengunjung/search', [PengunjungDashboardController::class, 'search'])->name('pengunjung.search');
    Route::get('/pengunjung/katalog', [DashboardController::class, 'katalog'])->name('pengunjung.katalog');
    Route::get('/pengunjung/cari', [DashboardController::class, 'cari'])->name('pengunjung.cari');
    Route::get('/pengunjung/riwayat', [DashboardController::class, 'riwayat'])->name('pengunjung.riwayat');
    Route::get('/pengunjung/perpanjang', [DashboardController::class, 'perpanjang'])->name('pengunjung.perpanjang');
    Route::get('/pengunjung/Profile', [ProfileController::class, 'index'])->name('pengunjung.profile');

});
