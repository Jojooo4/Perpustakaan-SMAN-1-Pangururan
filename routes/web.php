<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;

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

// Registration removed: routes were deleted per project configuration

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
    // Admin: view password reset requests submitted by users without email
    Route::get('/admin/password-requests', [\App\Http\Controllers\Admin\PasswordRequestsController::class, 'index'])->name('admin.password_requests');
});
