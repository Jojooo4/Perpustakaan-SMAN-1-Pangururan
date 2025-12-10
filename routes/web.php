<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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
Route::middleware(['auth'])->group(function () {
    
    // ========== ADMIN ROUTES ==========
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // MANAJEMEN BUKU
    Route::get('/manajemen_buku', [BukuController::class, 'index'])->name('buku.index');
    Route::post('/manajemen_buku', [BukuController::class, 'store'])->name('buku.store');
    Route::put('/manajemen_buku/{id_buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/manajemen_buku/{id_buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
    Route::get('/manajemen_buku/{id_buku}', [BukuController::class, 'show'])->name('buku.show');
    
    // MANAJEMEN PENGGUNA (ADMIN ONLY)
    Route::get('/manajemen-pengguna', [PengelolaanController::class, 'pengguna'])->name('pengelolaan.pengguna');
    Route::post('/manajemen-pengguna', [PengelolaanController::class, 'storeUser'])->name('pengelolaan.pengguna.store');
    Route::put('/manajemen-pengguna/{id_user}', [PengelolaanController::class, 'updateUser'])->name('pengelolaan.pengguna.update');
    Route::delete('/manajemen-pengguna/{id_user}', [PengelolaanController::class, 'destroyUser'])->name('pengelolaan.pengguna.destroy');
    
    // PEMINJAMAN & PENGEMBALIAN
    Route::get('/pinjam_kembali', [TransaksiController::class, 'index'])->name('transaksi.index');  
    Route::post('/pinjam_kembali', [TransaksiController::class, 'store'])->name('admin.loans.store');
    Route::get('/api/aset-buku/{id_buku}', [TransaksiController::class, 'getAsetByBuku']); // API for dynamic dropdown
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
    Route::get('/denda/export-pdf', [TransaksiController::class, 'exportDendaPdf'])->name('denda.export-pdf');
    
    // REVIEW ULASAN  
    Route::get('/review-ulasan', [PengelolaanController::class, 'review'])->name('pengelolaan.review');
    Route::get('/api/reviews/{id_buku}', [PengelolaanController::class, 'getBookReviews']);
    Route::delete('/review-ulasan/{id}', [PengelolaanController::class, 'destroyReview'])->name('pengelolaan.review.destroy');
    
    // REQUEST PEMINJAMAN
    Route::get('/request-peminjaman', [\App\Http\Controllers\Admin\RequestPeminjamanController::class, 'index'])->name('admin.request-peminjaman.index');
    Route::post('/request-peminjaman/{id}/approve', [\App\Http\Controllers\Admin\RequestPeminjamanController::class, 'approve'])->name('admin.request-peminjaman.approve');
    Route::post('/request-peminjaman/{id}/reject', [\App\Http\Controllers\Admin\RequestPeminjamanController::class, 'reject'])->name('admin.request-peminjaman.reject');
    
    // LOG AKTIVITAS
    Route::get('/log-aktivitas', [\App\Http\Controllers\Admin\LogAktivitasController::class, 'index'])->name('admin.log-aktivitas');
    
    // PENGATURAN PROFIL (ADMIN)
    Route::get('/pengaturan-profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::post('/pengaturan-profil', [ProfilController::class, 'update'])->name('profil.update');
    
    // ========== PETUGAS ROUTES ==========
    Route::prefix('petugas')->name('petugas.')->group(function() {
        Route::get('/', [PetugasDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [PetugasProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [PetugasProfileController::class, 'update'])->name('profile.update');
        
        // Petugas can access these features (using admin controllers)
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::put('/buku/{id_buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{id_buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
        Route::get('/buku/{id_buku}', [BukuController::class, 'show'])->name('buku.show');
        
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::post('/transaksi/{id}/kembali', [TransaksiController::class, 'return'])->name('transaksi.return');
        Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
        
        Route::get('/perpanjangan', [TransaksiController::class, 'perpanjangan'])->name('perpanjangan.index');
        Route::post('/perpanjangan/{id}/approve', [TransaksiController::class, 'approve'])->name('perpanjangan.approve');
        Route::post('/perpanjangan/{id}/reject', [TransaksiController::class, 'reject'])->name('perpanjangan.reject');
        
        Route::get('/denda', [TransaksiController::class, 'laporanDenda'])->name('denda.index');
        Route::post('/denda/{id}/lunas', [TransaksiController::class, 'markPaid'])->name('denda.mark-paid');
        
        Route::get('/review', [PengelolaanController::class, 'review'])->name('pengelolaan.review');
        Route::delete('/review/{id}', [PengelolaanController::class, 'destroyReview'])->name('pengelolaan.review.destroy');
        
        // Request Peminjaman
        Route::get('/request-peminjaman', [\App\Http\Controllers\Petugas\RequestPeminjamanController::class, 'index'])->name('request-peminjaman.index');
        Route::post('/request-peminjaman/{id}/approve', [\App\Http\Controllers\Petugas\RequestPeminjamanController::class, 'approve'])->name('request-peminjaman.approve');
        Route::post('/request-peminjaman/{id}/reject', [\App\Http\Controllers\Petugas\RequestPeminjamanController::class, 'reject'])->name('request-peminjaman.reject');
    });
    
    // ========== PENGUNJUNG ROUTES ==========
    Route::prefix('pengunjung')->name('pengunjung.')->group(function() {
        Route::get('/', [PengunjungDashboardController::class, 'index'])->name('dashboard');
        
        // Catalog & Borrow
        Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
        Route::get('/catalog/{id_buku}', [CatalogController::class, 'show'])->name('catalog.show');
        Route::post('/catalog/{id_buku}/borrow', [CatalogController::class, 'borrow'])->name('catalog.borrow');
        
        // My Requests
        Route::get('/my-requests', [PengunjungDashboardController::class, 'myRequests'])->name('my-requests');
        Route::delete('/my-requests/{id}/cancel', [PengunjungDashboardController::class, 'cancelRequest'])->name('my-requests.cancel');
        
        // Reviews
        Route::get('/reviews/{id_buku}/create', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        
        // Extensions
        Route::get('/extensions', [PengunjungExtensionController::class, 'index'])->name('extensions');
        Route::post('/extensions', [PengunjungExtensionController::class, 'store'])->name('extensions.store');
        
        // Profile
        Route::get('/profile', [PengunjungProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [PengunjungProfileController::class, 'update'])->name('profile.update');
    });
});