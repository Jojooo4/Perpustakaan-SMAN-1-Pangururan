@extends('layouts.pengunjung')

@section('title', 'Dashboard')

@section('content') 
<div class="dashboard-container-fluid">
    <!-- Hero Section with Slideshow -->
    <div class="hero-section">
        <div class="hero-slideshow-wrapper">
            <div class="hero-slideshow">
                <img src="{{ asset('assets/buku1.jpg') }}" alt="Koleksi Buku 1" class="slide active">
                <img src="{{ asset('assets/buku2.jpg') }}" alt="Koleksi Buku 2" class="slide">
                <img src="{{ asset('assets/buku3.jpg') }}" alt="Koleksi Buku 3" class="slide">
                <img src="{{ asset('assets/buku4.jpg') }}" alt="Koleksi Buku 4" class="slide">
                <img src="{{ asset('assets/buku5.jpg') }}" alt="Koleksi Buku 5" class="slide">
            </div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1 class="hero-title">SELAMAT DATANG {{ Auth::user()->nama ?? 'Pengunjung' }}</h1>
                <p class="hero-subtitle">DI PERPUSTAKAAN SMA NEGERI 1 PANGURURAN</p>
                <p class="hero-quote">"Buku adalah jembatan yang menghubungkan kita dengan dunia tanpa batas."</p>
            </div>
        </div>
    </div>

    <!-- Welcome Section with Quick Stats -->
    <section class="welcome-section">
        <div class="welcome-container-fluid">
            <h2 class="welcome-greeting">Halo, {{ Auth::user()->nama ?? 'Pengunjung' }}! 👋</h2>
            <p class="welcome-subtext">Jelajahi koleksi buku favorit Anda dan kelola peminjaman dengan mudah</p>
            
            <!-- Quick Stats -->
            <div class="stats-container-fluid">
                <div class="stat-card">
                    <div class="stat-icon">📚</div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $peminjamanAktif ?? 0 }}</div>
                        <div class="stat-label">Sedang Dipinjam</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📖</div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $totalPeminjaman ?? 0 }}</div>
                        <div class="stat-label">Total Pinjaman</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⚠️</div>
                    <div class="stat-content">
                        <div class="stat-value">Rp {{ number_format($dendaBelumLunas ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-label">Denda Belum Lunas</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions Section -->
    <section class="quick-actions-section">
        <div class="actions-container-fluid">
            <a href="{{ route('pengunjung.catalog') }}" class="action-card">
                <div class="action-icon"><i class="fas fa-book"></i></div>
                <span class="action-label">Koleksi</span>
                <span class="action-desc">Jelajahi</span>
            </a>
            <a href="{{ route('pengunjung.extensions') }}" class="action-card">
                <div class="action-icon"><i class="fas fa-sync"></i></div>
                <span class="action-label">Perpanjangan</span>
                <span class="action-desc">Kelola</span>
            </a>
            <a href="{{ route('pengunjung.profile') }}" class="action-card">
                <div class="action-icon"><i class="fas fa-user"></i></div>
                <span class="action-label">Profil</span>
                <span class="action-desc">Lihat</span>
            </a>
            <a href="#riwayat-section" class="action-card">
                <div class="action-icon"><i class="fas fa-history"></i></div>
                <span class="action-label">Riwayat</span>
                <span class="action-desc">Cek</span>
            </a>
        </div>
    </section>

    <!-- Active Loans Section -->
    <section class="loans-section" id="loans-aktif">
        <div class="loans-container-fluid">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-bookmark"></i> Peminjaman Aktif</h2>
            </div>

            <div class="section-content">
                @if(!empty($peminjamanAktifList) && $peminjamanAktifList->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="table-wrapper d-none d-md-block">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Pengarang</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamanAktifList as $p)
                                <tr>
                                    <td class="font-weight-600">{{ $p->asetBuku->buku->judul ?? 'N/A' }}</td>
                                    <td class="text-muted">{{ $p->asetBuku->buku->pengarang ?? '-' }}</td>
                                    <td>{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d M Y') : '-' }}</td>
                                    <td>
                                        <span class="jatuh-tempo">{{ $p->tanggal_jatuh_tempo ? $p->tanggal_jatuh_tempo->format('d M Y') : '-' }}</span>
                                        @if(method_exists($p, 'isTerlambat') && $p->isTerlambat())
                                            <div class="badge badge-danger badge-sm">Terlambat</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->status_peminjaman == 'Dipinjam')
                                            <span class="badge badge-success badge-lg">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary badge-lg">{{ $p->status_peminjaman }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('pengunjung.extensions') }}" class="btn-renew">
                                            <i class="fas fa-sync-alt"></i> Perpanjang
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none">
                        @foreach($peminjamanAktifList as $p)
                        <div class="loan-card-mobile">
                            <div class="loan-card-header">
                                <div class="loan-info">
                                    <h4 class="loan-title">{{ $p->asetBuku->buku->judul ?? 'N/A' }}</h4>
                                    <p class="loan-author">{{ $p->asetBuku->buku->pengarang ?? '-' }}</p>
                                </div>
                                @if($p->status_peminjaman == 'Dipinjam')
                                    <span class="badge badge-success badge-lg">Aktif</span>
                                @else
                                    <span class="badge badge-secondary badge-lg">{{ $p->status_peminjaman }}</span>
                                @endif
                            </div>
                            <div class="loan-dates">
                                <span><strong>Pinjam:</strong> {{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d M Y') : '-' }}</span>
                                <span><strong>Jatuh Tempo:</strong> {{ $p->tanggal_jatuh_tempo ? $p->tanggal_jatuh_tempo->format('d M Y') : '-' }}</span>
                            </div>
                            @if(method_exists($p, 'isTerlambat') && $p->isTerlambat())
                                <div class="alert alert-warning alert-sm">⚠️ Terlambat</div>
                            @endif
                            <a href="{{ route('pengunjung.extensions') }}" class="btn-renew-mobile">
                                <i class="fas fa-sync-alt"></i> Perpanjang
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">📚</div>
                        <h3>Tidak ada peminjaman aktif</h3>
                        <p>Jelajahi koleksi buku kami dan mulai peminjaman</p>
                        <a href="{{ route('pengunjung.catalog') }}" class="btn btn-primary">
                            <i class="fas fa-book"></i> Jelajahi Koleksi
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Loan History Section -->
    <section class="loans-section" id="riwayat-section">
        <div class="loans-container-fluid">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-clock"></i> Riwayat Peminjaman</h2>
            </div>

            <div class="section-content">
                @if(!empty($riwayatPeminjaman) && $riwayatPeminjaman->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="table-wrapper d-none d-md-block">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Pengarang</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Status</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatPeminjaman as $p)
                                <tr>
                                    <td class="font-weight-600">{{ $p->asetBuku->buku->judul ?? 'N/A' }}</td>
                                    <td class="text-muted">{{ $p->asetBuku->buku->pengarang ?? '-' }}</td>
                                    <td>{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d M Y') : '-' }}</td>
                                    <td>{{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d M Y') : '-' }}</td>
                                    <td>
                                        @if($p->status_peminjaman == 'Dikembalikan')
                                            <span class="badge badge-success badge-lg">Dikembalikan</span>
                                        @elseif($p->status_peminjaman == 'Terlambat')
                                            <span class="badge badge-danger badge-lg">Terlambat</span>
                                        @else
                                            <span class="badge badge-secondary badge-lg">{{ $p->status_peminjaman }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($p->denda) && $p->denda > 0)
                                            <div>
                                                <span class="fine-amount">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                                                @if(isset($p->denda_lunas) && $p->denda_lunas)
                                                    <span class="badge badge-success badge-sm">Lunas</span>
                                                @else
                                                    <span class="badge badge-warning badge-sm">Belum Lunas</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none">
                        @foreach($riwayatPeminjaman as $p)
                        <div class="loan-card-mobile">
                            <div class="loan-card-header">
                                <div class="loan-info">
                                    <h4 class="loan-title">{{ $p->asetBuku->buku->judul ?? 'N/A' }}</h4>
                                    <p class="loan-author">{{ $p->asetBuku->buku->pengarang ?? '-' }}</p>
                                </div>
                                @if($p->status_peminjaman == 'Dikembalikan')
                                    <span class="badge badge-success badge-lg">Dikembalikan</span>
                                @elseif($p->status_peminjaman == 'Terlambat')
                                    <span class="badge badge-danger badge-lg">Terlambat</span>
                                @else
                                    <span class="badge badge-secondary badge-lg">{{ $p->status_peminjaman }}</span>
                                @endif
                            </div>
                            <div class="loan-dates">
                                <span><strong>Pinjam:</strong> {{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d M Y') : '-' }}</span>
                                <span><strong>Kembali:</strong> {{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d M Y') : '-' }}</span>
                            </div>
                            @if(isset($p->denda) && $p->denda > 0)
                            <div class="loan-fine">
                                <span class="fine-amount">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                                @if(isset($p->denda_lunas) && $p->denda_lunas)
                                    <span class="badge badge-success badge-sm">Lunas</span>
                                @else
                                    <span class="badge badge-warning badge-sm">Belum Lunas</span>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">📖</div>
                        <h3>Belum ada riwayat peminjaman</h3>
                        <p>Mulai pinjam buku dari koleksi perpustakaan kami</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    :root {
        /* Color Palette from Login */
        --navy: #2b3458;
        --navy-dark: #c7e1f2;
        --navy-light: #4aa0c9;
        --accent-color: #4aa0c9;
        --accent-2: #2b7cae;
        --accent-light: #a4d4e8;
        --coral: #e84b63;
        --coral-light: #f5a9b8;
        --success-soft: #7dd3c0;
        --warning-soft: #f5b547;
        --danger-soft: #f08080;
        --cream: #fbf9e7;
        --light-blue: #c7e1f2;

        /* Neutral Colors */
        --gray-900: #0f172a;
        --gray-700: #374151;
        --gray-600: #4b5563;
        --gray-500: #6b7280;
        --gray-400: #9ca3af;
        --gray-300: #d1d5db;
        --gray-200: #e5e7eb;
        --gray-100: #f3f4f6;
        --gray-100-2: #f8fafc;
        --white: #ffffff;

        /* Spacing */
        --spacing-base: 8px;
        --spacing-2: calc(var(--spacing-base) * 2);
        --spacing-3: calc(var(--spacing-base) * 3);
        --spacing-4: calc(var(--spacing-base) * 4);
        --spacing-6: calc(var(--spacing-base) * 6);
        --spacing-8: calc(var(--spacing-base) * 8);
    }

    /* Dashboard Container */
    .dashboard-container-fluid {
        width: 100%;
        background: var(--gray-100);
        min-height: calc(100vh - 70px);
    }

    /* ============================================
       HERO SECTION WITH SLIDESHOW
       ============================================ */
    .hero-section {
        position: relative;
        width: 100%;
        height: 50vh;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-slideshow-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .hero-slideshow {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .hero-slideshow .slide {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        transition: opacity 1.2s ease-in-out;
    }

    .hero-slideshow .slide.active {
        opacity: 1;
        z-index: 1;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(43, 52, 88, 0.55) 0%, rgba(35, 42, 74, 0.65) 100%);
        z-index: 2;
    }

    .hero-content {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        z-index: 3;
        padding: var(--spacing-8);
        color: var(--white);
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        line-height: 1.2;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        margin-bottom: var(--spacing-3);
    }

    .hero-subtitle {
        font-size: 1.25rem;
        font-weight: 300;
        margin: 0;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        margin-bottom: var(--spacing-6);
    }

    .hero-quote {
        font-size: 1rem;
        font-style: italic;
        margin: 0;
        max-width: 600px;
        opacity: 0.95;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    }

    /* ============================================
       WELCOME SECTION WITH STATS
       ============================================ */
    .welcome-section {
        padding: var(--spacing-8) var(--spacing-6);
        background: var(--white);
        text-align: center;
        border-bottom: 2px solid var(--gray-100);
    }

    .welcome-container-fluid {
        max-width: 1200px;
        margin: 0 auto;
    }

    .welcome-greeting {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--navy);
        margin: 0 0 var(--spacing-2) 0;
    }

    .welcome-subtext {
        font-size: 0.95rem;
        color: var(--gray-600);
        margin: 0 0 var(--spacing-8) 0;
    }

    .stats-container-fluid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: var(--spacing-6);
    }

    .stat-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #f3f4f6 100%);
        padding: var(--spacing-6);
        border-radius: 14px;
        border: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: var(--spacing-4);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(74, 160, 201, 0.12);
        border-color: var(--accent-light);
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    }

    .stat-icon {
        font-size: 2.5rem;
        flex-shrink: 0;
    }

    .stat-content {
        flex: 1;
        text-align: left;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--navy);
        margin: 0;
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--gray-600);
        margin: var(--spacing-2) 0 0 0;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ============================================
       QUICK ACTIONS SECTION
       ============================================ */
    .quick-actions-section {
        padding: var(--spacing-8) var(--spacing-6);
        background: var(--white);
        border-bottom: 1px solid var(--gray-100);
    }

    .actions-container-fluid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: var(--spacing-6);
    }

    .action-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: var(--spacing-8) var(--spacing-4);
        background: linear-gradient(135deg, #f0f7ff 0%, #f0f4ff 100%);
        border: 2px solid transparent;
        border-radius: 16px;
        text-decoration: none;
        color: var(--navy);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        gap: var(--spacing-3);
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .action-card:hover::before {
        left: 100%;
    }

    .action-card:hover {
        background: linear-gradient(135deg, var(--accent-light) 0%, rgba(74, 160, 201, 0.1) 100%);
        border-color: var(--accent-color);
        color: var(--accent-color);
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(74, 160, 201, 0.2);
    }

    .action-icon {
        font-size: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--accent-color), var(--accent-2));
        color: var(--white);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .action-card:hover .action-icon {
        transform: scale(1.1);
        box-shadow: 0 8px 16px rgba(74, 160, 201, 0.3);
    }

    .action-label {
        font-size: 1rem;
        font-weight: 700;
        text-align: center;
    }

    .action-desc {
        font-size: 0.75rem;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    /* ============================================
       LOANS SECTION
       ============================================ */
    .loans-section {
        padding: var(--spacing-8) var(--spacing-6);
        background: var(--gray-100);
    }

    .loans-container-fluid {
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-header {
        margin-bottom: var(--spacing-6);
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--navy);
        margin: 0;
        display: flex;
        align-items: center;
        gap: var(--spacing-3);
    }

    .section-title i {
        font-size: 1.5rem;
    }

    .section-content {
        background: var(--white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--gray-200);
    }

    /* ============================================
       TABLE STYLES
       ============================================ */
    .table-wrapper {
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
        margin: 0;
    }

    .modern-table thead {
        background: linear-gradient(90deg, var(--navy-dark) 0%, var(--navy) 100%);
        border-bottom: 3px solid var(--accent-color);
    }

    .modern-table thead th {
        padding: var(--spacing-4) var(--spacing-4);
        text-align: left;
        font-weight: 700;
        color: var(--white);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .modern-table tbody tr {
        border-bottom: 1px solid var(--gray-200);
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background-color: #fafbff;
    }

    .modern-table tbody tr:nth-child(even) {
        background-color: #fafbff;
    }

    .modern-table tbody tr:nth-child(even):hover {
        background-color: #f3f7fc;
    }

    .modern-table td {
        padding: var(--spacing-4);
        color: var(--gray-700);
    }

    .modern-table td.font-weight-600 {
        font-weight: 600;
        color: var(--navy);
    }

    .modern-table td.text-muted {
        color: var(--gray-600);
        font-size: 0.85rem;
    }

    .modern-table td.text-center {
        text-align: center;
    }

    .jatuh-tempo {
        display: block;
        margin-bottom: var(--spacing-2);
    }

    /* ============================================
       BADGE STYLES
       ============================================ */
    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        border: none;
    }

    .badge-lg {
        padding: 6px 14px;
        font-size: 0.85rem;
    }

    .badge-sm {
        padding: 3px 10px;
        font-size: 0.75rem;
    }

    .badge-success {
        background: linear-gradient(135deg, rgba(125, 211, 192, 0.15), rgba(165, 231, 212, 0.15));
        color: #047857;
        border: 1px solid rgba(125, 211, 192, 0.4);
    }

    .badge-danger {
        background: linear-gradient(135deg, rgba(240, 128, 128, 0.15), rgba(255, 160, 160, 0.15));
        color: #dc2626;
        border: 1px solid rgba(240, 128, 128, 0.4);
    }

    .badge-warning {
        background: linear-gradient(135deg, rgba(245, 181, 71, 0.15), rgba(255, 200, 100, 0.15));
        color: #d97706;
        border: 1px solid rgba(245, 181, 71, 0.4);
    }

    .badge-secondary {
        background: linear-gradient(135deg, rgba(107, 114, 128, 0.15), rgba(156, 163, 175, 0.15));
        color: #4aa0c9;
        border: 1px solid rgba(107, 114, 128, 0.4);
    }

    /* ============================================
       BUTTON STYLES
       ============================================ */
    .btn-renew {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-2);
        padding: 8px 16px;
        background: linear-gradient(90deg, var(--accent-color), var(--accent-2));
        color: var(--white);
        text-decoration: none;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(74, 160, 201, 0.2);
        cursor: pointer;
    }

    .btn-renew:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 160, 201, 0.3);
        color: var(--white);
        text-decoration: none;
    }

    .btn-renew:active {
        transform: translateY(0);
    }

    .btn-primary {
        background: linear-gradient(90deg, var(--accent-color), var(--accent-2));
        color: var(--white);
        border: none;
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(74, 160, 201, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 160, 201, 0.3);
        color: var(--white);
        text-decoration: none;
    }

    /* ============================================
       MOBILE CARD STYLES
       ============================================ */
    .loan-card-mobile {
        padding: var(--spacing-6);
        border-bottom: 1px solid var(--gray-200);
        background: var(--white);
        border-left: 4px solid var(--accent-color);
        transition: all 0.3s ease;
    }

    .loan-card-mobile:last-child {
        border-bottom: none;
    }


    .loan-card-mobile:hover {
        background: #fafbff;
        border-left-color: var(--accent-2);
    }

    .loan-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: var(--spacing-3);
        margin-bottom: var(--spacing-3);
    }

    .loan-info {
        flex: 1;
    }

    .loan-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--navy);
        margin: 0;
    }

    .loan-author {
        font-size: 0.8rem;
        color: var(--gray-600);
        margin: var(--spacing-2) 0 0 0;
    }

    .loan-dates {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-2);
        font-size: 0.8rem;
        color: var(--gray-700);
        margin-bottom: var(--spacing-3);
    }

    .loan-fine {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: var(--spacing-3);
        border-top: 1px solid var(--gray-200);
        margin-top: var(--spacing-3);
    }

    .fine-amount {
        font-weight: 700;
        color: var(--navy);
    }

    .alert {
        padding: var(--spacing-3);
        border-radius: 8px;
        margin-bottom: var(--spacing-3);
        border-left: 3px solid;
    }

    .alert-sm {
        padding: var(--spacing-2);
        font-size: 0.85rem;
        margin-bottom: var(--spacing-2);
    }

    .alert-warning {
        background: linear-gradient(135deg, rgba(245, 181, 71, 0.1), rgba(255, 200, 100, 0.1));
        border-left-color: #d97706;
        color: #d97706;
    }

    .btn-renew-mobile {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--spacing-2);
        width: 100%;
        padding: 10px 16px;
        background: linear-gradient(90deg, var(--accent-color), var(--accent-2));
        color: var(--white);
        text-decoration: none;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(74, 160, 201, 0.2);
        cursor: pointer;
    }

    .btn-renew-mobile:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 160, 201, 0.3);
        color: var(--white);
        text-decoration: none;
    }

    /* ============================================
       EMPTY STATE
       ============================================ */
    .empty-state {
        padding: var(--spacing-8);
        text-align: center;
        color: var(--gray-600);
    }

    .empty-icon {
        font-size: 3.5rem;
        margin-bottom: var(--spacing-3);
        display: block;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: var(--spacing-2);
    }

    .empty-state p {
        font-size: 0.95rem;
        color: var(--gray-600);
        margin-bottom: var(--spacing-6);
    }

    /* ============================================
       RESPONSIVE DESIGN
       ============================================ */
    @media (max-width: 768px) {
        .hero-section {
            height: 40vh;
        }

        .hero-title {
            font-size: 1.75rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .hero-quote {
            font-size: 0.9rem;
        }

        .welcome-section {
            padding: var(--spacing-6) var(--spacing-4);
        }

        .welcome-greeting {
            font-size: 1.5rem;
        }

        .stats-container-fluid {
            grid-template-columns: 1fr;
            gap: var(--spacing-4);
        }

        .stat-card {
            flex-direction: column;
            text-align: center;
        }

        .actions-container-fluid {
            grid-template-columns: repeat(2, 1fr);
            gap: var(--spacing-4);
        }

        .action-card {
            padding: var(--spacing-6) var(--spacing-3);
        }

        .loans-section {
            padding: var(--spacing-6) var(--spacing-4);
        }

        .section-title {
            font-size: 1.5rem;
        }

        .modern-table thead th,
        .modern-table td {
            padding: var(--spacing-3);
            font-size: 0.8rem;
        }

        .loan-card-mobile {
            padding: var(--spacing-4);
        }
    }

    @media (max-width: 480px) {
        .hero-section {
            height: 35vh;
        }

        .hero-title {
            font-size: 1.4rem;
        }

        .hero-subtitle {
            font-size: 0.9rem;
        }

        .hero-quote {
            font-size: 0.85rem;
        }

        .welcome-greeting {
            font-size: 1.25rem;
        }

        .stats-container-fluid {
            gap: var(--spacing-3);
        }

        .stat-card {
            padding: var(--spacing-4);
        }

        .stat-value {
            font-size: 1.25rem;
        }

        .stat-label {
            font-size: 0.7rem;
        }

        .actions-container-fluid {
            grid-template-columns: repeat(2, 1fr);
            gap: var(--spacing-3);
        }

        .action-card {
            padding: var(--spacing-4) var(--spacing-2);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            font-size: 2rem;
        }

        .action-label {
            font-size: 0.85rem;
        }

        .action-desc {
            display: none;
        }

        .modern-table {
            font-size: 0.75rem;
        }

        .modern-table thead th,
        .modern-table td {
            padding: var(--spacing-2);
        }

        .section-title {
            font-size: 1.25rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    (function() {
        const slides = document.querySelectorAll('.hero-slideshow .slide');
        if (!slides || slides.length === 0) return;

        let currentIndex = 0;
        const totalSlides = slides.length;
        const transitionInterval = 5000;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            showSlide(currentIndex);
        }

        // ensure the first slide is visible on load
        showSlide(currentIndex);

        const slideTimer = setInterval(nextSlide, transitionInterval);

        // Pause slideshow on hover for better accessibility on desktop
        const slideshowWrapper = document.querySelector('.hero-slideshow-wrapper');
        if (slideshowWrapper) {
            slideshowWrapper.addEventListener('mouseenter', () => clearInterval(slideTimer));
            slideshowWrapper.addEventListener('mouseleave', () => setInterval(nextSlide, transitionInterval));
        }
    })();
</script>
@endpush
