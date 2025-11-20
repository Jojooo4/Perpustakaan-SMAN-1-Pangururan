@extends('layouts.petugas')

@section('title','Dashboard Petugas')

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <h1 class="h3">Dashboard Petugas</h1>
      <p class="text-muted">Halo, {{ auth()->user()->nama ?? auth()->user()->username }}</p>
    </div>
  </div>
  <div class="row g-3">
    <div class="col-md-6"><div class="card p-3"><h5>Transaksi Terbaru</h5><p>—</p></div></div>
    <div class="col-md-6"><div class="card p-3"><h5>Pinjaman Tertunda</h5><p>—</p></div></div>
  </div>
@endsection
