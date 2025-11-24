@extends('layouts.auth')

@section('title', 'Instruksi Terkirim')

@section('content')
    <style>
        /* Larger, more readable typography for forgot/password confirmation */
        .auth-container { font-size: 1.05rem; }
        .auth-header img { max-width: 110px; }
        .auth-header h4 { font-size: 1.05rem; }
        .auth-body h1 { font-size: 1.6rem; margin-bottom: .5rem; font-weight: 600; }
        .auth-body p { font-size: 1.15rem; line-height: 1.6; }
        .btn-auth { font-size: 1.05rem; padding: .75rem 1rem; }
        @media (max-width: 576px) {
            .auth-body h1 { font-size: 1.35rem; }
            .auth-body p { font-size: 1.05rem; }
        }
    </style>

    <div class="auth-container text-center p-4">
        <div class="auth-header">
            <img src="{{ asset('assets/logo-website.png') }}" alt="Logo SMAN 1 Pangururan">
            <h4 class="fw-medium text-muted">Sistem Perpustakaan</h4>
        </div>

        <div class="auth-body mt-3">
            <h1 class="h5">Periksa Email Anda</h1>
            <p class="mt-2">Jika akun Anda terdaftar dan memiliki alamat email, instruksi untuk mereset password telah dikirim. Jika tidak menerima email, silakan hubungi administrator.</p>
            <div class="d-grid gap-2 mt-3">
                <a href="{{ route('login') }}" class="btn btn-auth">Kembali ke Login</a>
            </div>
        </div>
    </div>
@endsection
