@extends('layouts.pengunjung')

@section('title', 'Dashboard')

@section('content')
<div class="visitor-dashboard fade-in-dashboard">
<!-- Hero Welcome Section -->
<div class="hero-dashboard mb-4">
    <h2 class="hero-dashboard-title mb-2">
        Perpustakaan Digital<br>SMAN 1 Pangururan
    </h2>
    <p class="hero-dashboard-eyebrow mb-2">
        Selamat Datang, {{ auth()->user()->nama }}!
    </p>
    <p class="hero-dashboard-subtitle mb-3">
        Kelola peminjamanmu, pantau riwayat baca, dan temukan buku-buku menarik yang sesuai dengan minatmu.
    </p>
    <a href="{{ route('pengunjung.catalog') }}" class="btn btn-hero-search btn-lg">
        <i class="fas fa-search me-2"></i>
        Cari Buku
    </a>
</div>

<!-- Warning Banner for Overdue & Fines (now placed under hero button) -->
@if(($showOverdueModal ?? false) === true || ($dendaBelumLunas ?? 0) > 0)
<div id="importantWarningPopup" class="alert alert-danger alert-dismissible fade show shadow-lg important-warning-popup" role="alert" data-autohide="10000" style="border-radius: 16px; border-left: 6px solid #dc3545; background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%);">
    <div class="d-flex align-items-start">
        <div class="me-3" style="font-size: 2.5rem; color: #dc3545;">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="grow">
            <h5 class="alert-heading mb-2" style="color: #dc3545; font-weight: 700;">
                <i class="fas fa-bell me-2"></i>Peringatan Penting!
            </h5>
            
            @if(($showOverdueModal ?? false) === true)
            <p class="mb-2">
                <strong>Anda memiliki {{ count($overdueLoans ?? []) }} peminjaman yang terlambat.</strong>
                Harap segera mengembalikan buku ke perpustakaan.
            </p>
            @endif
            
            @if(($dendaBelumLunas ?? 0) > 0)
            <p class="mb-0">
                <i class="fas fa-money-bill-wave me-2"></i>
                Total denda belum lunas: <strong class="text-danger" style="font-size: 1.1rem;">Rp {{ number_format($dendaBelumLunas, 0, ',', '.') }}</strong>
            </p>
            @endif
            
            <div class="mt-3">
                <a href="{{ route('pengunjung.history') }}" class="btn btn-danger btn-sm me-2" style="border-radius: 8px;">
                    <i class="fas fa-history me-1"></i>Lihat Riwayat
                </a>
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="alert" style="border-radius: 8px;">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@if(($showOverdueModal ?? false) === true)
<!-- Professional Overdue Warning Modal -->
<div class="modal fade" id="overdueModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <!-- Header with gradient -->
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); padding: 2rem;">
                <div class="w-100 text-center">
                    <div class="warning-icon-circle mx-auto mb-3" style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    <h4 class="modal-title text-white fw-bold mb-1">
                        Peringatan Keterlambatan
                    </h4>
                    <p class="text-white mb-0" style="opacity: 0.9; font-size: 0.95rem;">
                        Anda memiliki peminjaman yang terlambat
                    </p>
                </div>
            </div>
            
            <!-- Body -->
            <div class="modal-body" style="padding: 2rem;">
                <div class="alert alert-warning mb-4" style="border-radius: 12px; border-left: 4px solid #ffc107;">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Perhatian!</strong> Harap segera mengembalikan buku ke perpustakaan untuk menghindari denda lebih lanjut.
                </div>
                
                <h6 class="mb-3 fw-bold text-dark"><i class="fas fa-list me-2"></i>Daftar Buku Terlambat:</h6>
                <div class="table-responsive" style="border-radius: 12px; overflow: hidden;">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th style="border: none; padding: 1rem;">Buku</th>
                                <th class="text-end" style="border: none; padding: 1rem;">Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($overdueLoans as $loan)
                            <tr>
                                <td style="padding: 1rem; vertical-align: middle;">
                                    <strong>{{ $loan->asetBuku->buku->judul ?? 'Buku' }}</strong>
                                </td>
                                <td class="text-end" style="padding: 1rem; vertical-align: middle;">
                                    <span class="badge bg-danger" style="font-size: 0.9rem; padding: 0.5rem 0.8rem;">
                                        Rp {{ number_format($loan->denda ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background: #fff3cd;">
                            <tr>
                                <td style="padding: 1rem; border: none;"><strong>Total Denda Belum Lunas:</strong></td>
                                <td class="text-end" style="padding: 1rem; border: none;">
                                    <strong class="text-danger" style="font-size: 1.2rem;">
                                        Rp {{ number_format(($dendaBelumLunas ?? 0), 0, ',', '.') }}
                                    </strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="modal-footer border-0" style="padding: 1.5rem 2rem; background: #f8f9fa;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.6rem 1.5rem;">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <a href="{{ route('pengunjung.history') }}" class="btn btn-primary" style="border-radius: 10px; padding: 0.6rem 1.5rem;">
                    <i class="fas fa-history me-2"></i>Lihat Riwayat
                </a>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modalEl = document.getElementById('overdueModal');
    if (modalEl) {
        // PROPER backdrop - blocks all interaction until closed
        var modal = new bootstrap.Modal(modalEl, { 
            backdrop: 'static',  // Can't click outside to close
            keyboard: false      // Can't press ESC to close
        });
        modal.show();
    }
});
</script>
@endpush
@endif

<!-- Statistics Cards with Gradients -->
<div class="row g-4 mb-4 stats-row">
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

<!-- Popular Books -->
<div class="card-modern mb-4">
    <div class="card-header-modern d-flex align-items-center justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-fire me-2"></i>Buku Populer
        </h5>
        <a href="{{ route('pengunjung.catalog') }}" class="btn btn-sm btn-light">
            Lihat Semua
        </a>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @forelse(($popularBooks ?? collect()) as $book)
                <div class="col-6 col-md-3">
                    <a href="{{ route('pengunjung.catalog.show', $book->id_buku) }}" class="popular-book-card">
                        <div class="popular-book-cover">
                            @if($book->gambar)
                                <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}">
                            @else
                                <div class="popular-book-cover-placeholder">
                                    <i class="fas fa-book"></i>
                                </div>
                            @endif

                            <div class="popular-book-badges">
                                @if(($book->borrow_count ?? 0) > 0)
                                    <span class="badge bg-dark">{{ $book->borrow_count }}x dipinjam</span>
                                @endif
                                @if(($book->stok_tersedia ?? 0) > 0)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Dipinjam</span>
                                @endif
                            </div>
                        </div>

                        <div class="popular-book-info">
                            <div class="popular-book-title" title="{{ $book->judul }}">
                                {{ $book->judul }}
                            </div>
                            <div class="popular-book-meta">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ \Illuminate\Support\Str::limit($book->nama_pengarang ?? 'N/A', 22) }}
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state py-4">
                        <i class="fas fa-book"></i>
                        <p>Belum ada rekomendasi buku populer</p>
                        <a href="{{ route('pengunjung.catalog') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Jelajahi Katalog
                        </a>
                    </div>
                </div>
            @endforelse
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
</div>
@endsection

@push('styles')
<style>
/* Layout & animation */
.visitor-dashboard {
    max-width: 1120px;
    margin: 0 auto;
    padding-top: 1.75rem;
}

/* Important warning popup (below topbar, near avatar) */
.important-warning-popup {
    position: static;
    margin: 0 auto 1.25rem;
    width: min(520px, 100%);
}

@media (max-width: 768px) {
    .important-warning-popup {
        width: 100%;
    }
}

.fade-in-dashboard {
    opacity: 0;
    animation: fadeInUp 0.6s ease-out forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hero section */
.hero-dashboard {
    background: transparent;
    color: var(--dark);
    border-radius: 0;
    padding: 3.25rem 1rem;
    box-shadow: none;
    border: none;
    backdrop-filter: none;
    position: relative;
    overflow: visible;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.hero-dashboard::before {
    content: none;
}

.hero-dashboard-eyebrow {
    font-size: 1.1rem;
    letter-spacing: 0.05em;
    text-transform: none;
    opacity: 0.88;
    font-weight: 400;
}

.hero-dashboard-eyebrow span {
    display: none;
}

.hero-dashboard-title {
    font-weight: 900;
    font-size: clamp(2.8rem, 4.5vw, 4.2rem);
    line-height: 1.1;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    text-shadow:
        0 2px 12px rgba(255, 255, 255, 0.85),
        0 10px 26px rgba(0, 0, 0, 0.12);
}

.hero-dashboard-subtitle {
    font-size: clamp(1rem, 1.15vw, 1.15rem);
    line-height: 1.6;
    opacity: 0.95;
    max-width: 900px;
    margin-inline: auto;
    color: rgba(11, 30, 53, 0.92);
    text-shadow:
        0 1px 10px rgba(255, 255, 255, 0.8),
        0 8px 18px rgba(0, 0, 0, 0.08);
}

.btn-hero-search {
    background: var(--primary);
    color: #ffffff;
    border: none;
    border-radius: 999px;
    padding-inline: 1.7rem;
    font-weight: 600;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    display: inline-flex;
    align-items: center;
}

.btn-hero-search:hover {
    color: #ffffff;
    background: var(--primary-dark);
    border: none;
    transform: translateY(-1px);
}

/* Gradient Statistics Cards */
.stat-card {
    background: #ffffff;
    border: 1px solid rgba(43, 52, 88, 0.18);
    border-radius: 10px;
    padding: 1.6rem 1.25rem;
    box-shadow: 0 10px 22px rgba(0, 0, 0, 0.12);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    position: relative;
    overflow: hidden;
    height: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.stat-card::before {
    content: none;
}

.gradient-primary::before { background: linear-gradient(135deg, #ff5b6a, #f48a8f); }
.gradient-blue::before { background: linear-gradient(135deg, #4a7dff, #8fb4ff); }
.gradient-warning::before { background: linear-gradient(135deg, #ffc107, #ffab00); }

.stat-card:hover {
    transform: translateY(-3px);
    border-color: rgba(43, 52, 88, 0.28);
    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.18);
}

.stat-icon {
    width: 74px;
    height: 74px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.6rem;
    margin-bottom: 0.9rem;
    background: rgba(199, 225, 242, 0.55);
    border: 1px solid rgba(43, 52, 88, 0.12);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
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
    font-size: clamp(1.2rem, 2vw, 1.7rem);
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: var(--dark);
    line-height: 1.15;
    word-break: break-word;
}

.stat-label {
    color: rgba(11, 30, 53, 0.85);
    font-size: 0.9rem;
    margin: 0;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

/* Popular Books */
.popular-book-card {
    display: block;
    text-decoration: none;
    color: inherit;
    background: #ffffff;
    border: 1px solid rgba(43, 52, 88, 0.10);
    border-radius: 14px;
    overflow: hidden;
    height: 100%;
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.10);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.popular-book-card:focus-visible {
    outline: 3px solid rgba(74, 160, 201, 0.35);
    outline-offset: 2px;
}

.popular-book-card:hover {
    transform: translateY(-2px);
    border-color: rgba(43, 52, 88, 0.18);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.14);
}

.popular-book-cover {
    position: relative;
    width: 100%;
    aspect-ratio: 3 / 4;
    background: #f8f9fa;
    overflow: hidden;
}

.popular-book-cover::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 46%;
    background: linear-gradient(to top, rgba(11, 30, 53, 0.55), rgba(11, 30, 53, 0));
    pointer-events: none;
}

.popular-book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.popular-book-cover-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(43, 52, 88, 0.35);
    font-size: 2rem;
}

.popular-book-badges {
    position: absolute;
    left: 0.6rem;
    right: 0.6rem;
    top: 0.6rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
    z-index: 1;
}

.popular-book-badges .badge {
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
}

.popular-book-info {
    padding: 0.85rem 0.95rem;
    border-top: 1px solid rgba(43, 52, 88, 0.08);
}

.popular-book-title {
    font-weight: 700;
    color: var(--dark);
    font-size: 0.98rem;
    line-height: 1.25;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.4em;
}

.popular-book-meta {
    margin-top: 0.4rem;
}

.popular-book-meta small {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
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
     box-shadow: 0 4px 16px rgba(235,69,95,0.25);
     color: var(--primary);
 }

/* Modern Card */
.card-modern {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 26px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    border: 1px solid rgba(43, 52, 88, 0.10);
}

.card-modern .card-body {
    padding: 1.25rem 1.5rem;
}

.card-header-modern {
    background: linear-gradient(135deg, var(--dark) 0%, #3d4a7a 100%);
    color: white;
    padding: 1rem 1.25rem;
    border-bottom: none;
}

.card-header-modern h5 {
    font-weight: 600;
    font-size: 1.15rem;
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
    padding: 1.75rem 1rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    opacity: 0.2;
    margin-bottom: 0.75rem;
}

.empty-state p {
    font-size: 1rem;
    margin-bottom: 1rem;
}

.empty-state .btn {
    padding: 0.55rem 1.1rem;
    border-radius: 10px;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .stat-number { font-size: 1.5rem; }
    .stat-icon { width: 50px; height: 50px; font-size: 1.5rem; }
    .quick-action-btn { padding: 1rem 0.5rem; }
    .quick-action-btn i { font-size: 1.5rem; }
    .quick-action-btn span { font-size: 0.8rem; }
}

/* Keep page scrollable when modal is NOT forcing static backdrop */
body.modal-open {
    overflow: hidden !important; /* Changed: allow Bootstrap to handle overflow */
}

/* Slightly lift the overdue modal towards the hero heading */
.overdue-hero-modal {
    margin-top: -8vh;
}

@media (max-width: 992px) {
    .overdue-hero-modal { margin-top: -4vh; }
}

/* Professional modal backdrop - darker and blocks interaction */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.7) !important;
    z-index: 1050;
}

.modal-backdrop.show {
    opacity: 1 !important;
}

/* Ensure modal sits above backdrop */
.modal { 
    z-index: 1055 !important;
}

.modal-dialog {
    z-index: 1056;
}
</style>
@endpush
