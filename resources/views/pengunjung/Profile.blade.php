@extends('layouts.pengunjung')

@section('title','Profil Saya')

@section('content')
<style>
    :root{
        --p-primary: #EB455F;
        --p-bg: #FCFFE7;
        --p-muted: #BAD7E9;
        --p-dark: #2B3467;
    }
    .profile-card{ border-radius:12px; box-shadow:0 8px 28px rgba(43,52,103,0.06); border:1px solid rgba(43,52,103,0.04); }
    .profile-avatar{ width:140px; height:140px; object-fit:cover; border-radius:12px; border:4px solid var(--p-primary); }
    .profile-key{ color:var(--p-dark); font-weight:600; }
    .profile-val{ color:#374151; }
    .btn-edit{ background:var(--p-primary); color:#fff; border:none; }
    .profile-header{ background: linear-gradient(90deg,var(--p-muted), rgba(186,215,233,0.08)); border-radius:12px 12px 0 0; padding:1rem; }
</style>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card profile-card p-3 text-center">
                <div class="profile-header mb-3">
                    <h5 class="mb-0" style="color:var(--p-dark)">Profil Saya</h5>
                    <small class="text-muted">Kelola informasi akun Anda</small>
                </div>
                <div class="card-body">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama ?? auth()->user()->username) }}&background=EB455F&color=fff&size=256" alt="avatar" class="profile-avatar mb-3">
                    <h5 class="mb-0">{{ auth()->user()->nama ?? auth()->user()->username }}</h5>
                    <p class="text-muted small mb-3">@if(isset(auth()->user()->role)){{ auth()->user()->role }}@endif</p>
                    <a href="{{ route('pengunjung.profile.edit') ?? '#' }}" class="btn btn-edit w-100">Edit Profil</a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card profile-card p-3">
                <div class="card-body">
                    <h6 class="mb-3" style="color:var(--p-dark)">Informasi Akun</h6>
                    <div class="row mb-2">
                        <div class="col-sm-4 profile-key">Nama</div>
                        <div class="col-sm-8 profile-val">{{ auth()->user()->nama ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 profile-key">Username</div>
                        <div class="col-sm-8 profile-val">{{ auth()->user()->username ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 profile-key">Email</div>
                        <div class="col-sm-8 profile-val">{{ auth()->user()->email ?? '-' }}</div>
                    </div>
                    @if(isset(auth()->user()->nip) || isset(auth()->user()->nisn))
                    <div class="row mb-2">
                        <div class="col-sm-4 profile-key">NIP / NISN</div>
                        <div class="col-sm-8 profile-val">{{ auth()->user()->nip ?? auth()->user()->nisn ?? '-' }}</div>
                    </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-sm-4 profile-key">Bergabung</div>
                        <div class="col-sm-8 profile-val">{{ auth()->user()->created_at?->format('d M Y') ?? '-' }}</div>
                    </div>

                    <hr>
                    <div class="d-flex gap-2">
                        <a href="{{ route('pengunjung.password.change') ?? '#' }}" class="btn btn-outline-secondary">Ganti Password</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger ms-auto">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
