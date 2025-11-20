@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-12">
        <h1 class="h3">Dashboard Admin</h1>
        <p class="text-muted">Selamat datang, {{ auth()->user()->nama ?? auth()->user()->username ?? auth()->user()->email }}</p>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-md-4">
        <div class="card p-3">
          <h5 class="mb-1">Statistik Buku</h5>
          <p class="h2">—</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <h5 class="mb-1">Pengunjung Hari Ini</h5>
          <p class="h2">—</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <h5 class="mb-1">Pengaturan</h5>
          <p><a href="#">Kelola Pengguna</a></p>
        </div>
      </div>
    </div>
  </div>
@endsection
