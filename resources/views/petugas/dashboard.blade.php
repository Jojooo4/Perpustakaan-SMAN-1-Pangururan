@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')
@section('page-title', 'Dashboard Petugas')

@section('content')
<div class="hero-card mb-5">
    <span class="hero-badge"><i class="fas fa-shield-alt"></i> AREA PETUGAS</span>
    <h2>Dashboard Operasional</h2>
    <p>Pantau statistik utama perpustakaan dan jalankan proses transaksi dengan akses cepat dari satu layar.</p>
    <div class="hero-actions">
        <a href="{{ route('transaksi.index') }}" class="btn btn-accent">
            <i class="fas fa-plus"></i>
            Pinjam Buku
        </a>
        <a href="{{ route('transaksi.index') }}" class="btn btn-accent-outline">
            <i class="fas fa-undo"></i>
            Kembalikan Buku
        </a>
        <a href="{{ route('buku.index') }}" class="btn btn-accent-outline">
            <i class="fas fa-book"></i>
            Lihat Buku
        </a>
        <a href="{{ route('perpanjangan.index') }}" class="btn btn-accent-outline">
            <i class="fas fa-clock"></i>
            Perpanjangan
        </a>
    </div>
</div>

<div class="dash-grid mb-4">
    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p>Peminjaman Aktif</p>
                <h3>{{ $peminjamanAktif ?? 0 }}</h3>
            </div>
            <div class="stat-icon icon-warning">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p>Total Buku</p>
                <h3>{{ $totalBuku ?? 0 }}</h3>
            </div>
            <div class="stat-icon icon-primary">
                <i class="fas fa-book"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p>Pengunjung Aktif</p>
                <h3>{{ $pengunjungAktif ?? 0 }}</h3>
            </div>
            <div class="stat-icon icon-secondary">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>

<div class="welcome-panel">
    <i class="fas fa-user-tie"></i>
    <h5 class="mt-3">Selamat Datang, {{ auth()->user()->nama ?? 'Petugas' }}!</h5>
    <p class="mb-0">Gunakan menu navigasi untuk mengelola perpustakaan</p>
</div>
@endsection