@extends('layouts.auth')

@section('title', 'Register - Sistem Perpustakaan SMAN 1 Pangururan')

@section('content')
    <div class="auth-container">
        <div class="auth-header">
            <img src="{{ asset('assets/logo-website.png') }}" alt="Logo SMAN 1 Pangururan">
            <h4 class="fw-medium text-muted">Sistem Perpustakaan</h4>
            <h1 class="fw-bolder text-uppercase">SMAN 1 Pangururan</h1>
        </div>

        <div class="auth-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">Username (NIP / NISN)</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email (opsional)</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label for="nip" class="form-label">NIP (opsional)</label>
                    <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip') }}">
                </div>

                <div class="mb-3">
                    <label for="nisn" class="form-label">NISN (opsional)</label>
                    <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn') }}">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="pengunjung">Pengunjung</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-auth">Daftar</button>
                    <a href="{{ route('login') }}" class="btn btn-back-home">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
@endsection
