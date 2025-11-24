@extends('layouts.auth')

@section('title', 'Login - Sistem Perpustakaan SMAN 1 Pangururan')

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

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="mb-3">
                    <label for="identifier" class="form-label">NIP / NISN</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-id-card"></i>
                        </span>
                        <input type="text" class="form-control @error('identifier') is-invalid @enderror" id="identifier"
                            name="identifier" placeholder="Masukkan NIP atau NISN" value="{{ old('identifier') }}" required autofocus>
                        @error('identifier')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group password-input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Masukkan password Anda" required>
                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input border-2" id="remember" name="remember">
                        <label class="form-check-label text-dark fw-medium" for="remember">Ingat saya</label>
                    </div>
                    <div class="form-check">
                        <a href="{{ route('password.request') }}" class="text-dark fw-bold text-decoration-none">Lupa Password?</a>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-auth mb-2">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>


                    <a href="{{ url('/') }}" class="btn btn-outline-primary mb-2 w-100">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </form>

            <div class="auth-footer">
                <p>&copy; {{ date('Y') }} Perpustakaan SMAN 1 PANGURURAN. All rights reserved.</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            if (togglePassword && password) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    }
                });

                togglePassword.addEventListener('touchstart', function(e) { e.preventDefault(); });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            let viewport = document.querySelector('meta[name="viewport"]');
            
            window.addEventListener('focusin', function() { viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, user-scalable=no'); });
            
            window.addEventListener('focusout', function() { viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, user-scalable=yes'); });
        });
    </script>
@endpush

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
        /* Override layout background for the login page only */
        body::before {
            background-image: url("{{ asset('assets/bg-image-login.jpg') }}") !important;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Increase transparency so background image shows through more */
        .auth-container {
            background-color: rgba(255, 255, 255, 0.55) !important;
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            border: 1px solid rgba(255,255,255,0.12);
            box-shadow: none;
        }

        /* Make header and logo area transparent as well so whole form is translucent */
        .auth-header {
            background-color: transparent !important;
            padding-top: 18px;
            padding-bottom: 6px;
        }

        .auth-header img {
            background: transparent !important;
            display: inline-block;
        }

        /* Keep input fields slightly opaque for readability */
        .auth-body .form-control,
        .auth-body .input-group-text {
            background-color: rgba(255,255,255,0.92) !important;
        }

        /* Footer transparent */
        .auth-footer {
            background: transparent !important;
        }

        /* Slightly dim header text to match the transparent container */
        .auth-header h1, .auth-header h4 {
            color: var(--primary-color);
        }

        /* Button styles (colour only) */
        .btn-auth {
            background: linear-gradient(90deg, var(--accent-color), var(--accent-2));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 16px;
            font-weight: 700;
        }
        .btn-outline-primary {
            color: var(--accent-color);
            border-color: var(--accent-color);
            border-width: 2px;
            font-weight: 700;
            padding: 10px 14px;
            border-radius: 10px;
            background: transparent;
            box-shadow: 0 6px 18px rgba(74,160,201,0.10);
            transition: var(--transition);
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus {
            background: rgba(74,160,201,0.14);
            color: var(--navy-dark);
            border-color: var(--accent-2);
            text-decoration: none;
        }

        .btn-back-home {
            background: transparent !important;
            color: var(--accent-color) !important;
            border: 2px solid var(--accent-color) !important;
            border-radius: 10px;
            padding: 12px 16px;
            font-weight: 700;
            box-shadow: 0 8px 22px rgba(74,160,201,0.12) !important;
            backdrop-filter: blur(4px);
        }
        .btn-back-home:hover, .btn-back-home:focus {
            background: rgba(74,160,201,0.16) !important;
            color: var(--navy-dark) !important;
            border-color: var(--accent-2) !important;
            text-decoration: none;
        }

        /* input-group icons */
        .auth-body .input-group-text { color: var(--primary-dark); }
    </style>
@endpush
