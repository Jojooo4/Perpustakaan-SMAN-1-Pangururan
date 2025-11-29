@extends('layouts.pengunjung')

@section('title', 'Profil')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card-custom p-4 mb-4">
            <div class="text-center mb-4">
                <div class="user-avatar mx-auto" style="width: 100px; height: 100px; font-size: 2.5rem;">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 1)) }}
                </div>
                <h5 class="mt-3">{{ auth()->user()->nama }}</h5>
                <p class="text-muted">{{ auth()->user()->username }}</p>
            </div>
            
            <form action="{{ route('pengunjung.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <h6 class="mb-3">Informasi Profil</h6>
                
                <div class="mb-3">
                    <label class="form-label">Username</label>
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
