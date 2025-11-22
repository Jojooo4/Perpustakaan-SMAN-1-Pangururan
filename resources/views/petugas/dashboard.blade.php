@extends('layouts.petugas')

@section('title','Dashboard Petugas')

@section('styles')
<style>
    .stat-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        transition: transform .2s ease, box-shadow .2s ease;
        color: #fff;
        height: 100%; /* penting: samakan tinggi semua card */
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08);
    }
    .stat-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.85);
    }
    .stat-title {
        font-size: .9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        opacity: .9;
    }
    .stat-value {
        font-size: 1.9rem;
        font-weight: 700;
        margin-top: .25rem;
    }
    .stat-card .bi {
        font-size: 1.7rem;
    }

    .stat-total-peminjaman      { background: linear-gradient(135deg, #4e73df, #224abe); }
    .stat-koleksi-buku          { background: linear-gradient(135deg, #1cc88a, #0f9f66); }
    .stat-peminjaman-tertunda   { background: linear-gradient(135deg, #f6c23e, #f4b30d); }
    .stat-pengajuan-digital     { background: linear-gradient(135deg, #e74a3b, #be2617); }

    .card {
        border-radius: 16px;
        border: none;
    }
    .card-header {
        background: #fff;
        border-bottom: 1px solid rgba(0,0,0,.05);
        border-radius: 16px 16px 0 0 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Dashboard Petugas</h1>
        <div class="small text-muted d-none d-md-block">
            Halo, <span class="fw-semibold">{{ auth()->user()->nama ?? auth()->user()->username }}</span>
        </div>
    </div>

    {{-- 4 KARTU STATISTIK --}}
    <div class="row mb-4 gy-3">
        {{-- 1. Total Peminjaman --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card stat-total-peminjaman h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-title">Total Peminjaman</div>
                        <div class="stat-value">{{ $totalPeminjaman ?? 0 }}</div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Koleksi Buku --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card stat-koleksi-buku h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-title">Koleksi Buku</div>
                        <div class="stat-value">{{ $totalBuku ?? 0 }}</div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-book"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Peminjaman Tertunda --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card stat-peminjaman-tertunda h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-title">Peminjaman Tertunda</div>
                        <div class="stat-value">{{ $totalPeminjamanTertunda ?? 0 }}</div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Pengajuan Digital --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card stat-pengajuan-digital h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-title">Pengajuan Digital</div>
                        <div class="stat-value">{{ $totalPengajuanDigital ?? 0 }}</div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-journal-text"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GRAFIK + PERMINTAAN PERPANJANGAN & REVIEW --}}
    <div class="row mb-4">
        {{-- Grafik Tren Peminjaman --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0">Grafik Tren Peminjaman (6 Bulan)</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartPeminjaman" height="120"></canvas>
                </div>
            </div>
        </div>

        {{-- Permintaan Perpanjangan dan Review --}}
        <div class="col-lg-4 mb-4">
            {{-- Permintaan Perpanjangan --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Permintaan Perpanjangan (3 Terbaru)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $permintaanData = isset($permintaanPerpanjanganTerbaru) ? $permintaanPerpanjanganTerbaru : [];
                            @endphp
                            @forelse($permintaanData as $permintaan)
                                <tr>
                                    <td>{{ $permintaan->anggota->nama ?? '-' }}</td>
                                    <td>{{ $permintaan->buku->judul ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('perpanjangan.setujui', $permintaan->id ?? 0) }}" class="btn btn-sm btn-primary">
                                            Setujui
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted small py-3">
                                        Belum ada permintaan perpanjangan.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Review Terbaru --}}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">Review Terbaru</h6>
                </div>
                <div class="card-body">
                    @php
                        $reviewData = isset($reviewTerbaru) ? $reviewTerbaru : [];
                    @endphp
                    <ul class="list-unstyled mb-0">
                        @forelse($reviewData as $review)
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="me-2 mt-1">
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">"{{ $review->isi ?? '' }}"</div>
                                        <div class="small text-muted">
                                            {{ $review->anggota->nama ?? 'Anonim' }} -
                                            <span class="fst-italic">{{ $review->buku->judul ?? 'Buku' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-muted small">
                                Belum ada ulasan buku dari pengunjung.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        const canvas = document.getElementById('chartPeminjaman');
        if (!canvas) return;

        const labels           = {!! json_encode($chartLabels       ?? []) !!};
        const dataPeminjaman   = {!! json_encode($chartPeminjaman   ?? []) !!};
        const dataPengembalian = {!! json_encode($chartPengembalian ?? []) !!};

        const container = canvas.parentElement;

        const hasData =
            Array.isArray(labels) &&
            labels.length > 0 &&
            Array.isArray(dataPeminjaman) &&
            dataPeminjaman.length > 0 &&
            Array.isArray(dataPengembalian) &&
            dataPengembalian.length > 0;

        if (!hasData) {
            container.removeChild(canvas);

            const placeholder = document.createElement('p');
            placeholder.className = 'text-muted small mb-0';
            placeholder.innerText = 'Belum ada data peminjaman untuk ditampilkan.';
            container.appendChild(placeholder);

            return;
        }

        const ctx = canvas.getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Peminjaman',
                        data: dataPeminjaman,
                        tension: 0.35,
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Pengembalian',
                        data: dataPengembalian,
                        tension: 0.35,
                        borderWidth: 2,
                        borderDash: [4, 4],
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    })();
</script>
@endsection
