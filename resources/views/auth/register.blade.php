@extends('layouts.auth')

@section('title', 'Registrasi Dinonaktifkan')

@section('content')
    <div class="auth-container text-center p-4">
        <div class="auth-header">
            <img src="{{ asset('assets/logo-website.png') }}" alt="Logo SMAN 1 Pangururan">
            <h4 class="fw-medium text-muted">Sistem Perpustakaan</h4>
            <h1 class="fw-bolder text-uppercase">Pendaftaran Dinonaktifkan</h1>
        </div>

        <div class="auth-body mt-3">
            <p class="lead">Pendaftaran akun baru saat ini dinonaktifkan. Silakan hubungi administrator jika Anda membutuhkan akses.</p>
            <div class="d-grid gap-2 mt-3">
                <a href="{{ route('login') }}" class="btn btn-auth">Kembali ke Login</a>
            </div>
        </div>
    </div>
@endsection
