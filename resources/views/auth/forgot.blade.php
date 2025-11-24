@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
    <div class="auth-container">
        <div class="auth-header">
            <img src="{{ asset('assets/logo-website.png') }}" alt="Logo SMAN 1 Pangururan">
            <h4 class="fw-medium text-muted">Sistem Perpustakaan</h4>
            <h1 class="fw-bolder text-uppercase">Lupa Password</h1>
        </div>

        <div class="auth-body">
            <p class="mb-3">Silakan chat operator dan sertakan <strong>NISN</strong> Anda di pesan.</p>

            <div class="mb-4 contact-box">
                <div class="contact-inner">
                    <p class="mb-2 fw-semibold">Kontak Operator</p>
                    <p class="mb-1"><i class="fab fa-whatsapp me-2" style="color:var(--accent-color)"></i><a href="https://wa.me/6281234567890" target="_blank" rel="noopener">+62 812-3456-7890</a></p>
                    <p class="mb-0"><i class="fas fa-envelope me-2" style="color:var(--accent-color)"></i><a href="mailto:operator@example.com">operator@example.com</a></p>
                </div>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('login') }}" class="btn btn-auth mb-2">
                    <i class="fas fa-sign-in-alt me-2"></i>Kembali ke Login
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --navy: #2b3458;
            --navy-dark: #232a4a;
            --coral: #e84b63;
            --coral-2: #ff7b84;
            --cream: #fbf9e7;
            --light-blue: #c7e1f2;

            --primary-color: var(--navy);
            --primary-dark: var(--navy-dark);
            --accent-color: #4aa0c9; /* darker blue from palette */
            --accent-2: #2b7cae;
            --secondary-color: var(--light-blue);
            --light-color: var(--cream);
        }

        /* Match login background and transparency */
        body::before {
            background-image: url("{{ asset('assets/bg-image-login.jpg') }}") !important;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Match login transparency and inputs */
        .auth-container {
            background-color: rgba(255,255,255,0.55) !important;
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            border: 1px solid rgba(255,255,255,0.12);
            box-shadow: none;
            padding: 22px;
            border-radius: 12px;
        }

        .auth-header { background-color: transparent !important; padding-top: 12px; padding-bottom: 6px; }
        .auth-header img { background: transparent !important; display: inline-block; max-height:72px; }

        .auth-body .form-control, .auth-body .input-group-text { background-color: rgba(255,255,255,0.92) !important; }

        .auth-footer { background: transparent !important; }

        .btn-auth { background: linear-gradient(90deg, var(--accent-color), var(--accent-2)); color: #fff; border: none; border-radius: 10px; padding: 10px 14px; font-weight:700; }

        .btn-back-home { background: transparent !important; color: var(--accent-color) !important; border: 2px solid var(--accent-color) !important; border-radius: 10px; padding: 10px 14px; font-weight:700; }
        .btn-back-home:hover { background: rgba(74,160,201,0.12) !important; color: var(--navy-dark) !important; }
    </style>
@endpush

@push('styles')
    <style>
        /* contact-box blends with the auth-container background */
        .contact-box { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.10); border-radius:10px; padding:18px; }
        .contact-box p { margin:0 0 .4rem; font-size:1.05rem; line-height:1.45; }
        .contact-box .fw-semibold { color: var(--navy-dark); font-size:1.12rem; margin-bottom:.45rem; }
        .contact-box a { color: var(--accent-color); font-weight:700; text-decoration:none; font-size:1.05rem; }
        .contact-box a:hover { text-decoration:underline; }
        .contact-box i { font-size:1.08rem; vertical-align:middle; margin-right:8px; color: #000 !important; }
        @media (max-width:576px) {
            .contact-box p { font-size:1rem; }
            .contact-box a { font-size:1rem; }
            .contact-box .fw-semibold { font-size:1.02rem; }
        }
    </style>
@endpush
