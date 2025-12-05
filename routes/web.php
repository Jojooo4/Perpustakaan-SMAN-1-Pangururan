<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{LoginController, ForgotPasswordController};
use App\Http\Controllers\Admin\{
    DashboardController,
    BukuController,
    TransaksiController,
    PengelolaanController,
    ProfilController
};
use App\Http\Controllers\Petugas\{
    DashboardController as PetugasDashboardController,
    ProfileController as PetugasProfileController
};
use App\Http\Controllers\Pengunjung\{
    DashboardController as PengunjungDashboardController,
    CatalogController,
    ReviewController,
    ExtensionController as PengunjungExtensionController,
    ProfileController as PengunjungProfileController
};

// PUBLIC ROUTES
Route::get('/', function () {
    return view('index');
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
Route::middleware(['auth'])->group(function () {
    
    // ========== ADMIN ROUTES ==========
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // MANAJEMEN BUKU
    Route::get('/manajemen_buku', [BukuController::class, 'index'])->name('buku.index');
    Route::post('/manajemen_buku', [BukuController::class, 'store'])->name('buku.store');
    Route::put('/manajemen_buku/{kode_buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/manajemen_buku/{kode_buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
    Route::get('/manajemen_buku/{kode_buku}', [BukuController::class, 'show'])->name('buku.show');
    
    // MANAJEMEN PENGGUNA (ADMIN ONLY)
    Route::get('/manajemen-pengguna', [PengelolaanController::class, 'pengguna'])->name('pengelolaan.pengguna');
    Route::post('/manajemen-pengguna', [PengelolaanController::class, 'storeUser'])->name('pengelolaan.pengguna.store');
    Route::put('/manajemen-pengguna/{id_user}', [PengelolaanController::class, 'updateUser'])->name('pengelolaan.pengguna.update');
    Route::delete('/manajemen-pengguna/{id_user}', [PengelolaanController::class, 'destroyUser'])->name('pengelolaan.pengguna.destroy');
    
    // PEMINJAMAN & PENGEMBALIAN
    Route::get('/pinjam_kembali', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/pinjam_kembali', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/pinjam_kembali/{id}/kembali', [TransaksiController::class, 'return'])->name('transaksi.return');
    Route::delete('/pinjam_kembali/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    
    // PERPANJANGAN
    Route::get('/permintaan_perpanjangan', [TransaksiController::class, 'perpanjangan'])->name('perpanjangan.index');
    Route::post('/permintaan_perpanjangan/{id}/approve', [TransaksiController::class, 'approve'])->name('perpanjangan.approve');
    Route::post('/permintaan_perpanjangan/{id}/reject', [TransaksiController::class, 'reject'])->name('perpanjangan.reject');
    
    // LAPORAN DENDA
    Route::get('/laporan-denda', [TransaksiController::class, 'laporanDenda'])->name('denda.index');
    Route::post('/laporan-denda/{id}/lunas', [TransaksiController::class, 'markPaid'])->name('denda.mark-paid');
    Route::get('/denda/export', [TransaksiController::class, 'exportDenda'])->name('denda.export');
    
    // REVIEW ULASAN  
    Route::get('/review-ulasan', [PengelolaanController::class, 'review'])->name('pengelolaan.review');
    Route::delete('/review-ulasan/{id}', [PengelolaanController::class, 'destroyReview'])->name('pengelolaan.review.destroy');
    
    // PENGATURAN PROFIL (ADMIN)
    Route::get('/pengaturan-profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::post('/pengaturan-profil', [ProfilController::class, 'update'])->name('profil.update');
    
    // ========== PETUGAS ROUTES ==========
    Route::get('/petugas', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');
    Route::get('/petugas/profile', [PetugasProfileController::class, 'index'])->name('petugas.profile');
    Route::post('/petugas/profile', [PetugasProfileController::class, 'update'])->name('petugas.profile.update');
    
    // ========== PENGUNJUNG ROUTES ==========
    Route::prefix('pengunjung')->name('pengunjung.')->group(function() {
        Route::get('/', [PengunjungDashboardController::class, 'index'])->name('dashboard');
        
        // Catalog & Borrow
        Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
        Route::get('/catalog/{kode_buku}', [CatalogController::class, 'show'])->name('catalog.show');
        Route::post('/catalog/{kode_buku}/borrow', [CatalogController::class, 'borrow'])->name('catalog.borrow');
        
        // Reviews
        Route::get('/reviews/{kode_buku}/create', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        
        // Extensions
        Route::get('/extensions', [PengunjungExtensionController::class, 'index'])->name('extensions');
        Route::post('/extensions', [PengunjungExtensionController::class, 'store'])->name('extensions.store');
        
        // Profile
        Route::get('/profile', [PengunjungProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [PengunjungProfileController::class, 'update'])->name('profile.update');
    });
});