@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')
@section('page-title', 'Dashboard Petugas')

@section('content')
<div class="row g-3 mb-4">
    <!-- Stat Cards -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Peminjaman Aktif</p>
                    <h3 class="mb-0">{{ $peminjamanAktif ?? 0 }}</h3>
                </div>
                <div class="stat-icon icon-warning">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Total Buku</p>
                    <h3 class="mb-0">{{ $totalBuku ?? 0 }}</h3>
                </div>
                <div class="stat-icon icon-primary">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Pengunjung Aktif</p>
                    <h3 class="mb-0">{{ $pengunjungAktif ?? 0 }}</h3>
                </div>
                <div class="stat-icon icon-secondary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="stat-card">
            <h6 class="mb-3"><i class="fas fa-bolt me-2" style="color: var(--primary);"></i>Aksi Cepat</h6>
            <div class="row g-2">
                <div class="col-md-3 col-6">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>Pinjam Buku
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-undo me-2"></i>Kembalikan Buku
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-book me-2"></i>Lihat Buku
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('perpanjangan.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-clock me-2"></i>Perpanjangan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Message -->
<div class="row g-3">
    <div class="col-12">
        <div class="stat-card text-center py-5">
            <i class="fas fa-user-tie" style="font-size: 3rem; color: var(--secondary); opacity: 0.3;"></i>
            <h5 class="mt-3">Selamat Datang, {{ auth()->user()->nama ?? 'Petugas' }}!</h5>
            <p class="text-muted">Gunakan menu navigasi untuk mengelola perpustakaan</p>
        </div>
    </div>
</div>
@endsection