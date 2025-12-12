@extends('layouts.pengunjung')

@section('title', 'Dashboard')

@section('content')
<!-- Hero Welcome Section -->
<div class="welcome-hero mb-4 p-4 rounded-3" style="background: linear-gradient(135deg, var(--primary) 0%, #c93551 100%); color: white;">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="mb-2">👋 Selamat Datang, {{ auth()->user()->nama }}!</h2>
            <p class="mb-0 opacity-90">Kelola peminjaman Anda dan jelajahi koleksi buku perpustakaan</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('pengunjung.catalog') }}" class="btn btn-light btn-lg">
                <i class="fas fa-search me-2"></i>Cari Buku
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards with Gradients -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card gradient-primary">
            <div class="stat-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $peminjamanAktif ?? 0 }}</h3>
                <p class="stat-label">Sedang Dipinjam</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card gradient-blue">
            <div class="stat-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $totalPeminjaman ?? 0 }}</h3>
                <p class="stat-label">Total Peminjaman</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card gradient-warning">
            <div class="stat-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">Rp {{ number_format($dendaBelumLunas ?? 0, 0, ',', '.') }}</h3>
                <p class="stat-label">Denda Belum Lunas</p>
            </div>
        </div>
    </div>
</div>


<!-- Active Loans -->
<div class="card-modern mb-4">
    <div class="card-header-modern">
        <h5 class="mb-0">
            <i class="fas fa-bookmark me-2"></i>Peminjaman Aktif
        </h5>
    </div>
    <div class="card-body">
        @if($peminjamanAktifList && $peminjamanAktifList->count() > 0)
            <!-- Desktop Table -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamanAktifList as $p)
                        <tr>
                            <td>
                                <strong class="text-dark">{{ $p->asetBuku->buku->judul ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $p->asetBuku->buku->pengarang ?? '' }}</small>
                            </td>
                            <td>{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d/m/Y') : '-' }}</td>
                            <td>
                                {{ $p->tanggal_jatuh_tempo ? $p->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}
                                @if($p->isTerlambat())
                                    <br><span class="badge bg-danger">Terlambat</span>
                                @endif
                            </td>
                            <td>
                                @if($p->status_peminjaman == 'Dipinjam')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">{{ $p->status_peminjaman }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pengunjung.extensions') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-clock me-1"></i>Perpanjang
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                @foreach($peminjamanAktifList as $p)
                <div class="loan-card-mobile mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong class="d-block">{{ $p->asetBuku->buku->judul ?? 'N/A' }}</strong>
                            <small class="text-muted">{{ $p->asetBuku->buku->pengarang ?? '' }}</small>
                        </div>
                        @if($p->status_peminjaman == 'Dipinjam')
                            <span class="badge bg-success">Aktif</span>
                        @endif
                    </div>
                    <div class="d-flex gap-3 mb-2 text-muted small">
                        <span><i class="fas fa-calendar"></i> {{ $p->tanggal_pinjam->format('d/m/Y') }}</span>
                        <span><i class="fas fa-clock"></i> {{ $p->tanggal_jatuh_tempo->format('d/m/Y') }}</span>
                    </div>
                    @if($p->isTerlambat())
                        <div class="alert alert-danger py-1 px-2 mb-2 small">
                            <i class="fas fa-exclamation-circle"></i> Terlambat
                        </div>
                    @endif
                    <a href="{{ route('pengunjung.extensions') }}" class="btn btn-sm btn-primary w-100">
                        <i class="fas fa-clock me-1"></i>Perpanjang
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Tidak ada peminjaman aktif</p>
                <a href="{{ route('pengunjung.catalog') }}" class="btn btn-primary">
                    <i class="fas fa-book me-2"></i>Jelajahi Buku
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Loan History -->
<div class="card-modern" id="riwayat">
    <div class="card-header-modern">
        <h5 class="mb-0">
            <i class="fas fa-history me-2"></i>Riwayat Peminjaman
        </h5>
    </div>
    <div class="card-body">
        @if($riwayatPeminjaman && $riwayatPeminjaman->count() > 0)
            <!-- Desktop Table -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Buku</th>
                            <th>Pinjam</th>
                            <th>Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatPeminjaman as $p)
                        <tr>
                            <td>{{ $p->asetBuku->buku->judul ?? 'N/A' }}</td>
                            <td>{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d/m/Y') : '-' }}</td>
                            <td>{{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($p->status_peminjaman == 'Dikembalikan')
                                    <span class="badge bg-success">Dikembalikan</span>
                                @elseif($p->status_peminjaman == 'Terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-warning">{{ $p->status_peminjaman }}</span>
                                @endif
                            </td>
                            <td>
                                @if($p->denda > 0)
                                    <span class="text-danger fw-bold">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                                    @if($p->denda_lunas)
                                        <br><span class="badge bg-success">Lunas</span>
                                    @else
                                        <br><span class="badge bg-danger">Belum Lunas</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                @foreach($riwayatPeminjaman as $p)
                <div class="loan-card-mobile mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <strong class="d-block">{{ $p->asetBuku->buku->judul ?? 'N/A' }}</strong>
                        @if($p->status_peminjaman == 'Dikembalikan')
                            <span class="badge bg-success">Dikembalikan</span>
                        @elseif($p->status_peminjaman == 'Terlambat')
                            <span class="badge bg-danger">Terlambat</span>
                        @endif
                    </div>
                    <div class="d-flex gap-3 mb-2 text-muted small">
                        <span><i class="fas fa-arrow-up"></i> {{ $p->tanggal_pinjam->format('d/m/Y') }}</span>
                        <span><i class="fas fa-arrow-down"></i> {{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d/m/Y') : '-' }}</span>
                    </div>
                    @if($p->denda > 0)
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-danger fw-bold">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                            @if($p->denda_lunas)
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-danger">Belum Lunas</span>
                            @endif
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-clock-rotate-left"></i>
                <p>Belum ada riwayat peminjaman</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* Gradient Statistics Cards */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    opacity: 0.1;
}

.gradient-primary::before { background: linear-gradient(135deg, #EB455F, #ff6b7a); }
.gradient-blue::before { background: linear-gradient(135deg, #5a9cc2, #BAD7E9); }
.gradient-warning::before { background: linear-gradient(135deg, #ffc107, #ffab00); }

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin-bottom: 1rem;
}

.gradient-primary .stat-icon {
    background: linear-gradient(135deg, rgba(235,69,95,0.1), rgba(255,107,122,0.1));
    color: #EB455F;
}

.gradient-blue .stat-icon {
    background: linear-gradient(135deg, rgba(90,156,194,0.1), rgba(186,215,233,0.2));
    color: #5a9cc2;
}

.gradient-warning .stat-icon {
    background: linear-gradient(135deg, rgba(255,193,7,0.1), rgba(255,171,0,0.1));
    color: #ffc107;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: var(--dark);
}

.stat-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
    font-weight: 500;
}

/* Quick Action Buttons */
.quick-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem 1rem;
    background: white;
    border-radius: 12px;
    text-decoration: none;
    color: var(--dark);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.3s;
}

.quick-action-btn i {
    font-size: 1.75rem;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.quick-action-btn span {
    font-size: 0.9rem;
    font-weight: 500;
}

.quick-action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 16px rgba(235,69,95,0.2);
    color: var(--primary);
}

/* Modern Card */
.card-modern {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    border: none;
}

.card-header-modern {
    background: linear-gradient(135deg, var(--dark) 0%, #3d4a7a 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    border-bottom: none;
}

.card-header-modern h5 {
    font-weight: 600;
    font-size: 1.25rem;
}

/* Mobile Loan Card */
.loan-card-mobile {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1rem;
    border-left: 4px solid var(--primary);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    opacity: 0.2;
    margin-bottom: 1rem;
}

.empty-state p {
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .stat-number { font-size: 1.5rem; }
    .stat-icon { width: 50px; height: 50px; font-size: 1.5rem; }
    .quick-action-btn { padding: 1rem 0.5rem; }
    .quick-action-btn i { font-size: 1.5rem; }
    .quick-action-btn span { font-size: 0.8rem; }
}
</style>
@endpush


