@extends('layouts.petugas')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* Card Stats Styles */
    .stat-card {
        border: none;
        border-radius: 15px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 3rem;
        opacity: 0.3;
    }
    
    /* Gradients */
    .bg-gradient-blue { background: linear-gradient(45deg, #4e73df, #224abe); }
    .bg-gradient-green { background: linear-gradient(45deg, #1cc88a, #13855c); }
    .bg-gradient-warning { background: linear-gradient(45deg, #f6c23e, #dda20a); }
    .bg-gradient-red { background: linear-gradient(45deg, #e74a3b, #be2617); }

    /* Chart Container */
    .chart-container {
        position: relative; 
        height: 300px; 
        width: 100%;
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-0">Dashboard</h2>
        <p class="text-muted mb-0">Selamat datang kembali, {{ auth()->user()->nama ?? 'Petugas' }}!</p>
    </div>
    <div class="text-muted small">
        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </div>
</div>

{{-- Baris Kartu Statistik --}}
<div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card bg-gradient-blue h-100 p-3">
            <div class="card-body">
                <h6 class="text-uppercase mb-1" style="font-size: 0.8rem;">Total Peminjaman</h6>
                <h2 class="fw-bold mb-0">{{ $totalPeminjaman ?? 0 }}</h2>
                <i class="bi bi-journal-bookmark-fill stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card stat-card bg-gradient-green h-100 p-3">
            <div class="card-body">
                <h6 class="text-uppercase mb-1" style="font-size: 0.8rem;">Koleksi Buku</h6>
                <h2 class="fw-bold mb-0">{{ $totalBuku ?? 0 }}</h2>
                <i class="bi bi-collection-fill stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card stat-card bg-gradient-warning h-100 p-3">
            <div class="card-body">
                <h6 class="text-uppercase mb-1" style="font-size: 0.8rem;">Peminjaman Tertunda</h6>
                <h2 class="fw-bold mb-0">{{ $totalPeminjamanTertunda ?? 0 }}</h2>
                <i class="bi bi-clock-history stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card stat-card bg-gradient-red h-100 p-3">
            <div class="card-body">
                <h6 class="text-uppercase mb-1" style="font-size: 0.8rem;">Pengajuan Digital</h6>
                <h2 class="fw-bold mb-0">{{ $totalPengajuanDigital ?? 0 }}</h2>
                <i class="bi bi-laptop stat-icon"></i>
            </div>
        </div>
    </div>
</div>

{{-- Area Grafik Peminjaman --}}
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-bottom-0 rounded-top-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-primary">Statistik Peminjaman Bulanan</h5>
                <select class="form-select form-select-sm w-auto border-0 bg-light shadow-sm fw-semibold text-muted">
                    <option value="2025">Tahun Ini</option>
                    <option value="2024">Tahun Lalu</option>
                </select>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="chartPeminjaman"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('chartPeminjaman').getContext('2d');

        // Data Dummy (Jika data backend belum ada, grafik tetap muncul) 

[Image of borrowing statistics chart]

        // Nanti ganti bagian ini dengan: const dataPeminjaman = {!! json_encode($chartPeminjaman ?? []) !!};
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const dataPeminjaman = [12, 19, 3, 5, 2, 3, 15, 10, 8, 12, 20, 25];
        const dataPengembalian = [10, 15, 2, 4, 2, 2, 12, 8, 7, 10, 18, 22];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Peminjaman',
                        data: dataPeminjaman,
                        borderColor: '#4e73df', // Warna Garis Biru
                        backgroundColor: 'rgba(78, 115, 223, 0.05)', // Warna Area Bawah Garis (Transparan)
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4e73df',
                        pointHoverBackgroundColor: '#4e73df',
                        pointHoverBorderColor: '#fff',
                        tension: 0.4, // Membuat garis melengkung halus (curved)
                        fill: true
                    },
                    {
                        label: 'Pengembalian',
                        data: dataPengembalian,
                        borderColor: '#1cc88a', // Warna Garis Hijau
                        backgroundColor: 'rgba(28, 200, 138, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#1cc88a',
                        tension: 0.4,
                        fill: true,
                        borderDash: [5, 5] // Garis putus-putus untuk pembeda
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#2c3e50',
                        bodyColor: '#2c3e50',
                        borderColor: '#e3e6f0',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: true
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#858796'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            borderDash: [2, 2],
                            drawBorder: false
                        },
                        ticks: {
                            color: '#858796',
                            padding: 10
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    });
</script>
@endsection