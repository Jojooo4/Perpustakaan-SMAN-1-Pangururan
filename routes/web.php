<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

// Registration routes
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

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
});
