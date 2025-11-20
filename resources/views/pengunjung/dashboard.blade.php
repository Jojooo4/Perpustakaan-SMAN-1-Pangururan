@extends('layouts.pengunjung')

@section('title','Dashboard Pengunjung')

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <h1 class="h3">Dashboard Pengunjung</h1>
      <p class="text-muted">Halo, {{ auth()->user()->nama ?? auth()->user()->username }}</p>
    </div>
  </div>
  <div class="row g-3">
    <div class="col-md-12">
      <div class="card p-3">
        <h5>Informasi Peminjaman</h5>
        <p>—</p>
      </div>
    </div>
  </div>
@endsection
