@extends('layouts.admin')

@section('title', 'Pengaturan Profil')
@section('page-title', 'Pengaturan Profil')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    $profileUser = auth()->user();
    $profilePhotoUrl = $profileUser->foto_profil ? Storage::url($profileUser->foto_profil) : null;
@endphp
<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="profile-card shadow-sm">
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                
                <div class="text-center mb-4">
                    <div class="profile-avatar mx-auto" style="{{ $profilePhotoUrl ? 'background-image: url(' . $profilePhotoUrl . ');' : '' }}">
                        @unless($profilePhotoUrl)
                            {{ strtoupper(substr($profileUser->nama ?? 'A', 0, 1)) }}
                        @endunless
                    </div>
                    <h5 class="mt-3 mb-0">{{ $profileUser->nama }}</h5>
                    <p class="text-muted mb-0 small">ADMIN PERPUSTAKAAN</p>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama" value="{{ auth()->user()->nama }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" name="foto_profil" accept="image/*">
                </div>
                
                <hr class="my-4">
                
                <h6 class="mb-3">Ubah Password</h6>
                
                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password" class="form-control" name="password_lama">
                    <small class="text-muted">Isi hanya jika ingin mengubah password</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" class="form-control" name="password_baru">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" name="password_baru_confirmation">
                </div>
                
                <div class="text-end pt-1">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 2.3rem 2.3rem 2.4rem;
        box-shadow: 0 28px 60px rgba(4, 10, 40, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.9);
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(140deg, #4aa0c9, #1f6fb2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 700;
        font-size: 2.4rem;
        text-transform: uppercase;
        box-shadow: 0 18px 45px rgba(6, 27, 79, 0.55);
        background-size: cover;
        background-position: center;
    }

    .profile-card .form-label {
        font-weight: 500;
        color: #0b1f3d;
    }

    .profile-card input.form-control,
    .profile-card select.form-select {
        border-radius: 0.9rem;
        border-color: rgba(15, 43, 93, 0.18);
    }

    .profile-card input.form-control:focus,
    .profile-card select.form-select:focus {
        box-shadow: 0 0 0 0.15rem rgba(66, 139, 202, 0.25);
        border-color: #4aa0c9;
    }
</style>
@endpush