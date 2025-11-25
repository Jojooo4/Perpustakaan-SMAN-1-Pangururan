@extends('layouts.petugas')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    {{-- Header Halaman --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('petugas.dashboard') }}" class="btn btn-light rounded-circle me-3 shadow-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h3 class="fw-bold mb-0">Profil Petugas</h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- Header Card Warna Biru --}}
                <div class="card-header text-white text-center py-4" style="background: #063852;">
                    <img src="{{ asset('images/foto-profil.jpg') }}" 
                         alt="Foto Profil" 
                         class="rounded-circle border border-4 border-white shadow mb-3" 
                         style="width: 120px; height: 120px; object-fit: cover;">
                    <h4 class="fw-bold mb-1">{{ $user->nama ?? auth()->user()->nama }}</h4>
                    <span class="badge bg-white text-primary rounded-pill px-3">Petugas Perpustakaan</span>
                </div>

                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase fw-bold mb-3 small ls-1">Informasi Akun</h6>
                    
                    <div class="mb-3 pb-3 border-bottom">
                        <label class="text-muted small">Nomor Induk Pegawai (NIP)</label>
                        <div class="fs-5 fw-medium text-dark">{{ $user->nip ?? auth()->user()->nip ?? '-' }}</div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <label class="text-muted small">Username</label>
                        <div class="fs-5 fw-medium text-dark">{{ $user->username ?? auth()->user()->username ?? '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Email</label>
                        <div class="fs-5 fw-medium text-dark">{{ $user->email ?? auth()->user()->email ?? '-' }}</div>
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-outline-primary rounded-pill">
                            <i class="bi bi-pencil-square me-2"></i> Edit Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection