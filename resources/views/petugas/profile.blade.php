@extends('layouts.petugas')

@section('title', 'Pengaturan Profil')
@section('page-title', 'Pengaturan Profil Petugas')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="stat-card">
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                
                <div class="text-center mb-4">
@php
    use Illuminate\Support\Facades\Storage;
    $pfUser = auth()->user();
    $pfAvatarUrl = $pfUser && $pfUser->foto_profil ? Storage::url($pfUser->foto_profil) : null;
    $pfInitial = strtoupper(substr($pfUser->nama ?? 'P', 0, 1));
@endphp
                    <div class="user-avatar mx-auto" style="width: 100px; height: 100px; font-size: 2rem; {{ $pfAvatarUrl ? 'background-image: url(' . $pfAvatarUrl . '); background-size: cover; background-position: center;' : '' }}">
                        @unless($pfAvatarUrl)
                            {{ $pfInitial }}
                        @endunless
                    </div>
                    <h5 class="mt-3">{{ auth()->user()->nama }}</h5>
                    <p class="text-muted">Petugas Perpustakaan</p>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" value="{{ auth()->user()->username }}" disabled>
                    <small class="text-muted">Username tidak dapat diubah</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama" value="{{ auth()->user()->nama }}" required>
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
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection