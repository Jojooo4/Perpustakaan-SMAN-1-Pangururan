@extends('layouts.pengunjung')

@section('title', 'Dashboard')

@section('content')
<!-- Hero Banner (modern public website style) -->
<div class="hero-banner mb-4 rounded-0" style="background-image: url('/assets/images/library-illustration.png'); background-size:cover; background-position:center;">
    <div class="hero-overlay rounded-0"></div>
    <div class="container position-relative">
        <div class="row align-items-center py-5">
            <div class="col-lg-7 col-md-8">
                <h1 class="hero-title">Selamat Datang di Perpustakaan SMAN 1 Pangururan</h1>
                <p class="hero-subtitle mb-4">Jelajahi koleksi, perpanjang pinjaman, dan temukan bacaan favoritmu dengan mudah.</p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('pengunjung.catalog') }}" class="btn btn-primary hero-cta">
                        <i class="fas fa-search me-2"></i>Cari Buku
                    </a>
                    <a href="{{ route('pengunjung.profile') }}" class="btn btn-outline-light hero-cta-link">Profil Saya</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Book (large book photo) -->
<section class="container featured-book mb-4">
    <div class="featured-card d-flex align-items-center gap-3 p-3">
        <img src="/assets/images/featured-book.jpg" alt="Featured Book" class="featured-cover rounded">
        <div class="flex-fill">
            <h3 class="mb-1">Buku Pilihan Minggu Ini</h3>
            <p class="mb-1 text-muted small">Judul &middot; Pengarang &middot; Kategori</p>
            <p class="mb-2 text-muted">Ringkasan singkat buku ini agar pengunjung tertarik membaca atau meminjam. Deskripsi pendek yang ramah siswa.</p>
            <a href="{{ route('pengunjung.catalog') }}" class="btn btn-sm btn-primary">Lihat di Katalog</a>
        </div>
    </div>
</section>

<!-- Statistics Cards (horizontal, lightweight) -->
<div class="container mb-4">
    <div class="d-flex gap-3 justify-content-center flex-wrap">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                <div>
                    <div class="stat-number">{{ $peminjamanAktif ?? 0 }}</div>
                    <div class="stat-label">Sedang Dipinjam</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon"><i class="fas fa-history"></i></div>
                <div>
                    <div class="stat-number">{{ $totalPeminjaman ?? 0 }}</div>
                    <div class="stat-label">Total Peminjaman</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                <div>
                    <div class="stat-number">Rp {{ number_format($dendaBelumLunas ?? 0, 0, ',', '.') }}</div>
                    <div class="stat-label">Denda Belum Lunas</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions (compact pills) -->
<div class="container mb-4">
    <div class="d-flex gap-2 flex-wrap justify-content-center">
        <a href="{{ route('pengunjung.catalog') }}" class="quick-action-btn">
            <i class="fas fa-book"></i>
            <span>Katalog</span>
        </a>
        <a href="{{ route('pengunjung.extensions') }}" class="quick-action-btn">
            <i class="fas fa-clock"></i>
            <span>Perpanjangan</span>
        </a>
        <a href="{{ route('pengunjung.profile') }}" class="quick-action-btn">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
        <a href="#riwayat" class="quick-action-btn">
            <i class="fas fa-list"></i>
            <span>Riwayat</span>
        </a>
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
:root {
  --primary-color: #01747B;
  --secondary-color: #00ABB5;
  --accent-color: #00D2DF;
  --light-color: #B5FBFF;
  --dark-color: #004F54;
  --bg-light: #f8fafb;
}

/* Global friendly typography */
body, .welcome-hero, .card-modern, .stat-card, .quick-action-btn {
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
}
body { font-size: 14px; color: #0f1720; background: var(--bg-light); }

/* Welcome / Hero: minimal and soft */
.welcome-hero { border: 1px solid rgba(1,116,123,0.06); }
.welcome-hero h2 { font-weight: 700; font-size: 1.25rem; margin-bottom: 0.15rem; }
.welcome-hero p { color: rgba(0,79,84,0.7); margin-bottom: 0; }

/* Compact statistic cards for users (not admin panels) */
.stat-card { background: white; border-radius: 12px; padding: 1rem 1.2rem; box-shadow: 0 2px 8px rgba(1,116,123,0.06); border: 1px solid rgba(1,116,123,0.08); min-width: 180px; }
.stat-icon { width:48px; height:48px; font-size:1.35rem; border-radius:10px; display:flex; align-items:center; justify-content:center; background: rgba(0,210,223,0.1); color: var(--primary-color); }
.stat-number { font-size:1.4rem; font-weight:700; color: var(--dark-color); margin-bottom: 0.2rem; }
.stat-label { font-size:0.85rem; color: rgba(0,0,0,0.65); margin: 0; }

/* Featured book section */
.featured-book { margin-top: -2rem; position: relative; z-index: 3; }
.featured-card { background: white; border-radius: 12px; box-shadow: 0 4px 16px rgba(1,116,123,0.1); border: 1px solid rgba(1,116,123,0.06); }
.featured-cover { width: 140px; height: 200px; object-fit: cover; flex-shrink: 0; }
.featured-card h3 { color: var(--dark-color); font-weight: 700; font-size: 1.1rem; }

/* Quick actions: small pill icons, horizontal on desktop */
.quick-action-btn { display:flex; flex-direction:row; gap:0.6rem; align-items:center; padding:0.5rem 0.75rem; border-radius:999px; background:white; border:1px solid rgba(0,0,0,0.04); color: var(--dark-color); text-decoration:none; }
.quick-action-btn i { font-size:1.1rem; color: var(--primary-color); margin:0; }
.quick-action-btn span { font-size:0.95rem; font-weight:600; }
.quick-action-btn:hover { transform:none; box-shadow: 0 2px 8px rgba(1,116,123,0.06); color: var(--secondary-color); }

/* Card headers and overall cards */
.card-modern { background: white; border-radius:12px; border:1px solid rgba(0,0,0,0.04); box-shadow: 0 6px 18px rgba(3,31,33,0.03); }
.card-header-modern { background: transparent; color: var(--dark-color); padding:0.8rem 1rem; border-bottom:1px solid rgba(0,0,0,0.04); }
.card-header-modern h5 { font-size:1rem; margin:0; font-weight:700; }

/* Loan table: softer, more spacious */
.table thead th { background: rgba(0,210,223,0.06); border-bottom: none; color: var(--dark-color); font-weight:700; font-size:0.95rem; }
.table tbody tr { border-bottom: 1px solid rgba(0,0,0,0.04); }
.table td, .table th { padding: 0.65rem 0.75rem; vertical-align: middle; }
.loan-card-mobile { background: #fbfeff; border-radius:10px; padding:0.8rem; border-left: 3px solid rgba(0,171,181,0.12); }

/* Empty states and subtle icons */
.empty-state i { color: rgba(0,0,0,0.1); }

/* Responsive tweaks */
@media (max-width:768px){
  .quick-action-btn { width:100%; justify-content:flex-start; }
  .stat-card { padding:0.8rem; }
}

/* Hero Banner styles */
.hero-banner{ position:relative; overflow:hidden; }
.hero-overlay{ position:absolute; inset:0; background: linear-gradient(180deg, rgba(0,0,0,0.45), rgba(0,0,0,0.2)); z-index:0; }
.hero-banner .container{ z-index:2; }
.hero-title{ font-size:2.25rem; color:#fff; font-weight:800; margin-bottom:0.25rem; text-shadow: 0 2px 8px rgba(0,0,0,0.35); }
.hero-subtitle{ color: rgba(255,255,255,0.9); font-size:1.05rem; margin-bottom:1rem; }
.hero-cta{ background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border:none; padding:0.6rem 1rem; border-radius:8px; }
.hero-cta-link{ color: rgba(255,255,255,0.9); border:1px solid rgba(255,255,255,0.12); background: transparent; padding:0.55rem 0.9rem; border-radius:8px; }
.hero-image{ max-width:220px; }

/* Navbar tweaks (styling only, keep structure) */
.navbar{ background: transparent !important; box-shadow:none !important; position:relative; }
.navbar.navbar-hero { position:absolute; left:0; right:0; top:0; z-index:4; }
.navbar .navbar-brand{ font-weight:700; color: rgba(255,255,255,0.95) !important; }
.navbar .nav-link{ color: rgba(255,255,255,0.9) !important; }

/* Stat icon circle */
.stat-icon { display:flex; align-items:center; justify-content:center; background: rgba(181,251,255,0.28); width:44px; height:44px; border-radius:10px; color: var(--primary-color); }

/* Subtle card shadows and rounded elements */
.card-modern, .stat-card, .quick-action-btn, .loan-card-mobile { border-radius:12px; }
.card-modern { box-shadow: 0 6px 18px rgba(3,31,33,0.03); }

</style>
@endpush


