@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="dashboard-shell">
    <section class="dashboard-hero">
        <div class="hero-top"></div>

        @php
            $heroStats = [
                ['label'=>'Anggota','value'=>$anggotaAktif ?? 0,'icon'=>'users','meta'=>'Aktif saat ini'],
                ['label'=>'Total Buku','value'=>$totalBuku ?? 0,'icon'=>'book','meta'=>'Tersedia di katalog'],
                ['label'=>'Stok Tersedia','value'=>$totalStok ?? 0,'icon'=>'boxes','meta'=>'Siap dipinjam'],
                ['label'=>'Peminjaman','value'=>$peminjamanAktif ?? 0,'icon'=>'clock','meta'=>'Sedang dipinjam'],
                ['label'=>'Total Denda','value'=>'Rp '.number_format($totalDenda ?? 0, 0, ',', '.'),'icon'=>'coins','meta'=>'Belum lunas']
            ];
            $topStats = array_slice($heroStats, 0, 3);
            $bottomStats = array_slice($heroStats, 3);
        @endphp
        <div class="hero-stats">
            <div class="hero-stats-row hero-stats-top">
                @foreach($topStats as $stat)
                    <div class="hero-stat-wrapper">
                        <div class="hero-stat-card">
                            <div class="stat-icon icon-primary"><i class="fas fa-{{ $stat['icon'] }}"></i></div>
                            <div>
                                <p class="stat-label">{{ $stat['label'] }}</p>
                                <h4>{{ $stat['value'] }}</h4>
                                <small>{{ $stat['meta'] }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="hero-stats-row hero-stats-bottom">
                @foreach($bottomStats as $stat)
                    <div class="hero-stat-wrapper hero-stat-wrapper--sm">
                        <div class="hero-stat-card">
                            <div class="stat-icon icon-primary"><i class="fas fa-{{ $stat['icon'] }}"></i></div>
                            <div>
                                <p class="stat-label">{{ $stat['label'] }}</p>
                                <h4>{{ $stat['value'] }}</h4>
                                <small>{{ $stat['meta'] }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="hero-content">
            <div class="hero-quick-stack">
                <div class="stat-card quick-actions">

                    @php
                        $quickActions = [
                            ['route'=>route('buku.index'),'label'=>'Tambah Buku','icon'=>'plus'],
                            ['route'=>route('transaksi.index'),'label'=>'Pinjam Buku','icon'=>'book-reader'],
                            ['route'=>route('pengelolaan.pengguna'),'label'=>'Tambah User','icon'=>'user-plus'],
                            ['route'=>route('denda.index'),'label'=>'Laporan Denda','icon'=>'file-invoice-dollar'],
                        ];
                    @endphp
                    <div class="quick-actions-header">
                        <span class="quick-icon"><i class="fas fa-bolt"></i></span>
                        <strong>Aksi Cepat</strong>
                    </div>
                    <div class="quick-actions-buttons">
                        @foreach($quickActions as $action)
                            <a href="{{ $action['route'] }}" class="quick-action-btn">
                                <i class="fas fa-{{ $action['icon'] }}"></i>
                                <span>{{ $action['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row gy-4 mt-3">
                <div class="col-12">
                    <div class="hero-table">
                        <div class="hero-table-header d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-uppercase small text-muted mb-1">Tabel</p>
                                <strong>Permintaan Perpanjangan</strong>
                            </div>
                            <a href="{{ route('perpanjangan.index') }}" class="text-decoration-none small text-primary">Lihat semua <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                        <div class="hero-table-body">
                            @if(isset($requestPending) && $requestPending->count() > 0)
                                @foreach($requestPending->take(4) as $request)
                                    <div class="hero-table-row">
                                        <div>
                                            <strong>{{ $request->peminjaman->user->nama ?? '-' }}</strong>
                                            <p class="mb-0 small">{{ $request->peminjaman->asetBuku->buku->judul ?? '-' }}</p>
                                        </div>
                                        <span class="badge badge-status">Pending</span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">Tidak ada permintaan perpanjangan baru.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="hero-graph">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-uppercase small text-muted mb-1">Grafik</p>
                                <strong>Perbandingan Peminjaman</strong>
                            </div>
                            <small class="text-muted">Bulan ini</small>
                        </div>
                        @php
                            $chartData = ['Jan'=>60,'Feb'=>45,'Mar'=>75,'Apr'=>55];
                        @endphp
                        <div class="graph-bars graph-horizontal">
                            @foreach($chartData as $label => $value)
                                <div class="graph-bar graph-bar-horizontal">
                                    <span class="bar-label">{{ $label }}</span>
                                    <div class="bar-track">
                                        <span class="bar-fill" style="width: {{ $value }}%;"></span>
                                    </div>
                                    <strong>{{ $value }}%</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="hero-review">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <strong>Review Terbaru</strong>
                            <a href="{{ route('pengelolaan.review') }}" class="text-decoration-none small">Semua</a>
                        </div>
                        @if(isset($reviewTerbaru) && $reviewTerbaru->count() > 0)
                            @foreach($reviewTerbaru->take(3) as $review)
                                <div class="hero-review-row">
                                    <div>
                                        <strong>{{ $review->user->nama ?? '-' }}</strong>
                                        <p class="mb-0 small">{{ $review->buku->judul ?? '-' }}</p>
                                    </div>
                                    <div class="hero-review-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($review->rating ?? 0) ? 'text-warning' : 'text-white-50' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="small mb-0 text-muted">Belum ada review terbaru.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="dashboard-activity">
        <div class="stat-card activity-card">
            <div class="activity-card-header">
                <h6 class="mb-0">Aktivitas Terbaru</h6>
                <a href="{{ route('admin.dashboard') }}" class="small text-decoration-none activity-refresh">Segarkan <i class="fas fa-sync-alt"></i></a>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-muted small mb-1">Permintaan</p>
                    <strong>{{ isset($requestPending) ? $requestPending->count() : 0 }}</strong>
                </div>
                <div>
                    <p class="text-muted small mb-1">Review</p>
                    <strong>{{ isset($reviewTerbaru) ? $reviewTerbaru->count() : 0 }}</strong>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .dashboard-shell {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
        color: #0b1a4a;
    }

    .dashboard-hero {
        border-radius: 28px;
        padding: 2.5rem;
        background: linear-gradient(145deg, #4c5cff, #7a84ff 60%, #c3cafe);
        color: #0b1a4a;
        box-shadow: 0 30px 60px rgba(15, 23, 85, 0.25);
        border: 1px solid rgba(42, 58, 123, 0.2);
    }

    .hero-top {
        width: 100%;
    }


    .hero-stats {
        margin-top: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .hero-stats-row {
        display: flex;
        gap: 1.25rem;
        justify-content: space-between;
    }

    .hero-stats-row.hero-stats-bottom {
        justify-content: center;
        margin-top: 0.25rem;
    }

    .hero-stat-wrapper {
        flex: 1;
        min-width: 180px;
    }

    .hero-stat-wrapper--sm {
        flex: 0 0 210px;
        max-width: 220px;
    }

    @media (max-width: 1180px) {
        .hero-stats-row {
            flex-wrap: wrap;
        }

        .hero-stat-wrapper,
        .hero-stat-wrapper--sm {
            max-width: none;
        }

        .hero-stats-row.hero-stats-bottom {
            justify-content: center;
        }
    }

    .hero-stat-card {
        background: rgba(255,255,255,0.95);
        border-radius: 18px;
        padding: 1rem 1.2rem;
        display: flex;
        gap: 1rem;
        align-items: center;
        border: 1px solid rgba(31, 52, 135, 0.1);
        min-height: 100px;
        box-shadow: 0 8px 18px rgba(15, 27, 77, 0.06);
        flex: 1;
    }

    .hero-stat-card .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.1rem;
        color: #5163c9;
    }

    .hero-stat-card h4 {
        margin: 0;
    }

    .hero-stat-card .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(63, 108, 255, 0.12);
        color: #1e3dc4;
    }

    .hero-content {
        margin-top: 2rem;
    }

    .hero-quick-stack {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .hero-quick-stack .stat-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 1.5rem;
        border: 1px solid rgba(31, 45, 107, 0.08);
        box-shadow: 0 20px 40px rgba(9, 19, 74, 0.08);
    }

    .quick-actions-header {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1rem;
        color: #1e2665;
    }

    .quick-icon {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        background: rgba(31, 52, 135, 0.2);
        display: grid;
        place-items: center;
        color: #1e2665;
    }

    .quick-actions-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .quick-action-btn {
        flex: 1 1 calc(25% - 0.75rem);
        border-radius: 12px;
        border: 1px solid #1e2665;
        background: #1e2665;
        color: #ffffff;
        font-weight: 600;
        padding: 0.85rem 1rem;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 0.5rem;
        text-decoration: none;
        min-width: 180px;
        box-shadow: 0 8px 18px rgba(23, 32, 112, 0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
    }

    .dashboard-activity {
        display: flex;
        justify-content: center;
        margin-top: 1.25rem;
    }

    .dashboard-activity .activity-card {
        width: 100%;
        max-width: 1180px;
        background: #ffffff;
        border-radius: 20px;
        padding: 1.5rem;
        border: 1px solid rgba(31, 45, 107, 0.1);
        box-shadow: 0 20px 40px rgba(9, 19, 74, 0.08);
    }

    .activity-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .activity-refresh {
        color: #1e2665;
    }

    .hero-table {
        background: #ffffff;
        border-radius: 20px;
        padding: 1.5rem;
        border: 1px solid rgba(31, 45, 107, 0.08);
        box-shadow: 0 24px 40px rgba(9, 19, 74, 0.08);
    }

    .hero-table-header strong {
        font-size: 1.1rem;
    }

    .hero-table-body {
        margin-top: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
    }

    .hero-table-row {
        background: #f4f6ff;
        border-radius: 14px;
        padding: 0.9rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .hero-table-row p {
        color: rgba(11, 26, 74, 0.7);
    }

    .badge-status {
        padding: 0.35rem 0.8rem;
        border-radius: 12px;
        background: rgba(63, 108, 255, 0.2);
        color: #1e3dc4;
        font-weight: 600;
    }

    .hero-graph {
        background: white;
        border-radius: 18px;
        padding: 1.4rem;
        color: #0a1a4e;
        box-shadow: 0 25px 50px rgba(5, 11, 65, 0.15);
    }

    .graph-bars {
        margin-top: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .graph-bar {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .graph-bar .bar-label {
        flex: 0 0 60px;
        font-size: 0.75rem;
        color: #5b5b82;
    }

    .graph-bar .bar-track {
        flex: 1;
        background: linear-gradient(90deg, #d5d9ff, #e7ecff);
        border-radius: 999px;
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
        height: 16px;
    }

    .graph-bar .bar-fill {
        width: 100%;
        background: linear-gradient(90deg, #3a50f4, #5b6fff);
        border-radius: 999px;
        height: 100%;
    }

    .graph-bar strong {
        width: 45px;
        text-align: right;
        font-size: 0.85rem;
        color: #4d4d7b;
    }

    .hero-review {
        background: #ffffff;
        border-radius: 18px;
        padding: 1.1rem 1.3rem;
        margin-top: 1rem;
        box-shadow: 0 20px 40px rgba(9, 19, 74, 0.08);
        color: #0d1f4c;
    }

    .hero-review-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.4rem 0;
        border-bottom: 1px solid rgba(13, 31, 76, 0.1);
    }

    .hero-review-row:last-child {
        border-bottom: none;
    }

    .hero-review-rating i {
        margin-left: 0.1rem;
        font-size: 0.7rem;
    }

    .quick-actions .quick-btn {
        border-radius: 10px;
        background: #ffffff;
        color: #1b2d8c;
        border: 1px solid rgba(27, 45, 140, 0.2);
        height: 45px;
        justify-content: flex-start;
        padding-left: 20px;
    }

    .activity-card strong {
        font-size: 1.4rem;
    }

    .activity-card a {
        color: #1b2d8c;
    }

    @media (max-width: 768px) {
        .dashboard-hero {
            padding: 2rem;
        }

        .hero-table-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .hero-review-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .activity-card {
            margin-top: 1rem;
        }
    }
</style>
@endpush
