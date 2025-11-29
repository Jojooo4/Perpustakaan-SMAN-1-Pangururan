@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="row g-3 mb-4">
    <!-- Stat Cards -->
    <div class="col-md-3">
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
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Stok Tersedia</p>
                    <h3 class="mb-0">{{ $totalStok ?? 0 }}</h3>
                </div>
                <div class="stat-icon icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
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
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Total Denda</p>
                    <h3 class="mb-0">Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="stat-icon icon-primary">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Anggota Aktif</p>
                    <h3 class="mb-0">{{ $anggotaAktif ?? 0 }}</h3>
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
                    <a href="{{ route('buku.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>Tambah Buku
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-exchange-alt me-2"></i>Pinjam Buku
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('pengelolaan.pengguna') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-user-plus me-2"></i>Tambah User
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('denda.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-file-export me-2"></i>Laporan Denda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-3">
    @if(isset($requestPending) && $requestPending->count() > 0)
    <div class="col-md-6">
        <div class="stat-card">
            <h6 class="mb-3"><i class="fas fa-clock me-2" style="color: var(--primary);"></i>Permintaan Perpanjangan</h6>
            <div class="list-group list-group-flush">
                @foreach($requestPending as $request)
                <div class="list-group-item border-0 px-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $request->peminjaman->user->nama ?? '-' }}</strong>
                            <p class="mb-0 text-muted small">{{ $request->peminjaman->asetBuku->buku->judul ?? '-' }}</p>
                        </div>
                        <span class="badge badge-status" style="background: rgba(255,193,7,0.2); color: #c4930b;">Pending</span>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('perpanjangan.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    @endif
    
    @if(isset($reviewTerbaru) && $reviewTerbaru->count() > 0)
    <div class="col-md-6">
        <div class="stat-card">
            <h6 class="mb-3"><i class="fas fa-star me-2" style="color: var(--primary);"></i>Review Terbaru</h6>
            <div class="list-group list-group-flush">
                @foreach($reviewTerbaru as $review)
                <div class="list-group-item border-0 px-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $review->user->nama ?? '-' }}</strong>
                            <p class="mb-0 text-muted small">{{ $review->buku->judul ?? '-' }}</p>
                            <div class="mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= ($review->rating ?? 0) ? 'text-warning' : 'text-muted' }}" style="font-size: 0.8rem;"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('pengelolaan.review') }}" class="btn btn-sm btn-outline-primary mt-2">
                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    @endif
</div>

@if((!isset($requestPending) || $requestPending->count() == 0) && (!isset($reviewTerbaru) || $reviewTerbaru->count() == 0))
<div class="row g-3">
    <div class="col-12">
        <div class="stat-card text-center py-5">
            <i class="fas fa-chart-line" style="font-size: 3rem; color: var(--secondary); opacity: 0.3;"></i>
            <h5 class="mt-3 text-muted">Selamat Datang di Dashboard Admin</h5>
            <p class="text-muted">Gunakan menu navigasi untuk mulai mengelola perpustakaan</p>
        </div>
    </div>
</div>
@endif

@endsection