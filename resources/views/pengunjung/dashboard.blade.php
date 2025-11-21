
@extends('layouts.pengunjung')

@section('title','Dashboard Pengunjung')

@section('content')
<style>
  :root {
    --main-blue: #0d6efd;
    --light-blue: #e3f0ff;
    --gradient-blue: linear-gradient(135deg, #0d6efd 60%, #6c63ff 100%);
  }
  .dashboard-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    border: 3px solid var(--main-blue);
    transition: transform 0.3s;
    background: var(--light-blue);
  }
  .dashboard-avatar:hover {
    transform: scale(1.08) rotate(-5deg);
  }
  .dashboard-card {
    transition: box-shadow 0.2s, transform 0.2s;
    border: none;
    border-radius: 1rem;
    box-shadow: 0 2px 12px rgba(13,110,253,0.10);
    background: var(--light-blue);
    color: #222;
  }
  .dashboard-card:hover {
    box-shadow: 0 4px 24px rgba(13,110,253,0.18);
    transform: translateY(-4px) scale(1.02);
  }
  .icon-bg {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-blue);
    color: #fff;
    font-size: 1.7rem;
    box-shadow: 0 2px 8px rgba(13,110,253,0.10);
    border: 2px solid #fff;
  }
  .book-img {
    width: 70px;
    height: 70px;
    object-fit: contain;
    margin-bottom: 10px;
    transition: transform 0.3s;
    filter: drop-shadow(0 2px 8px rgba(13,110,253,0.10));
    border-radius: 10px;
    border: 2px solid var(--main-blue);
    background: #fff;
    padding: 4px;
  }
  .book-img:hover {
    transform: scale(1.12) rotate(6deg);
    box-shadow: 0 4px 16px rgba(13,110,253,0.18);
  }
  .dashboard-header-bg {
    background: var(--gradient-blue);
    min-height: 120px;
    border-radius: 1rem;
    position: relative;
    overflow: hidden;
    color: #fff;
  }
  .dashboard-header-bg::after {
    content: '';
    position: absolute;
    right: 10px;
    top: 10px;
    width: 120px;
    height: 80px;
    background: url('https://cdn.pixabay.com/photo/2016/03/31/19/56/books-1294672_1280.png') no-repeat center center;
    background-size: contain;
    opacity: 0.18;
  }
</style>


<div class="container-fluid py-3">
  <div class="row mb-4 align-items-center dashboard-header-bg">
    <div class="col-auto pt-3 ps-2">
      <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama ?? auth()->user()->username) }}&background=0d6efd&color=fff" class="dashboard-avatar" alt="Avatar">
    </div>
    <div class="col pt-3">
      <h2 class="fw-bold mb-1" style="color:#fff;">Halo, {{ auth()->user()->nama ?? auth()->user()->username }}!</h2>
      <span class="text-light">Selamat datang di Dashboard Pengunjung</span>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card dashboard-card p-4 text-center">
        <img src="https://cdn.pixabay.com/photo/2014/04/02/10/55/open-book-306872_1280.png" alt="Buku" class="book-img mx-auto mb-2">
        <h5 class="fw-semibold" style="color:var(--main-blue);">Buku Dipinjam</h5>
        <p class="display-6 fw-bold mb-0" style="color:var(--main-blue);">—</p>
        <span class="text-muted">Total buku yang sedang Anda pinjam</span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card dashboard-card p-4 text-center">
        <div class="icon-bg mx-auto mb-2">
          <i class="bi bi-clock-history"></i>
        </div>
        <h5 class="fw-semibold" style="color:var(--main-blue);">Riwayat Peminjaman</h5>
        <p class="display-6 fw-bold mb-0" style="color:var(--main-blue);">—</p>
        <span class="text-muted">Jumlah peminjaman yang pernah dilakukan</span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card dashboard-card p-4 text-center">
        <div class="icon-bg mx-auto mb-2">
          <i class="bi bi-calendar-check"></i>
        </div>
        <h5 class="fw-semibold" style="color:var(--main-blue);">Jatuh Tempo</h5>
        <p class="display-6 fw-bold mb-0" style="color:var(--main-blue);">—</p>
        <span class="text-muted">Buku yang harus segera dikembalikan</span>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-12">
      <div class="card dashboard-card p-4">
        <h4 class="fw-bold mb-3" style="color:var(--main-blue);"><i class="bi bi-info-circle me-2"></i> Informasi Peminjaman</h4>
        <p class="mb-0">— Data peminjaman Anda akan tampil di sini. Silakan hubungi petugas jika ada kendala.</p>
      </div>
    </div>
  </div>
</div>


<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection
