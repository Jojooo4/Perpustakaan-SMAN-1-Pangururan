<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pengunjung') - Perpustakaan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #EB455F;
            --secondary: #BAD7E9;
            --dark: #2B3467;
            --light: #FCFFE7;
        }
        
        * {
            box-sizing: border-box;
        }
        
        html {
            font-size: 16px;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--light);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Fixed Width Container untuk Zoom Out */
        .content-container-fixed {
            max-width: 1200px !important;
            width: 100%;
            margin: 0 auto;
        }
        
        @media (max-width: 1400px) {
            .content-container-fixed {
                max-width: 1140px !important;
            }
        }
        
        @media (max-width: 1200px) {
            .content-container-fixed {
                max-width: 960px !important;
            }
        }
        
        @media (max-width: 992px) {
            .content-container-fixed {
                max-width: 720px !important;
            }
        }
        
        @media (max-width: 768px) {
            .content-container-fixed {
                max-width: 540px !important;
            }
        }
        
        @media (max-width: 576px) {
            .content-container-fixed {
                max-width: 100% !important;
                padding: 0 15px;
            }
        }
        
        .navbar-custom {
            background: var(--dark);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .navbar-custom .container {
            max-width: 1200px !important;
        }
        
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }
        
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.5rem 1rem;
            transition: all 0.3s;
            font-size: 1rem;
        }
        
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: var(--primary);
        }
        
        .content-wrapper {
            padding: 2rem 0;
            min-height: calc(100vh - 70px);
        }
        
        .card-custom {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: transform 0.3s, box-shadow 0.3s;
            max-width: 100%;
        }
        
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }
        
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background: #c93551;
            border-color: #c93551;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            font-weight: 600;
        }
        
        /* Prevent layout breaking on zoom */
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('pengunjung.dashboard') }}">
                <i class="fas fa-book-reader me-2"></i>Perpustakaan SMAN 1
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengunjung.dashboard') ? 'active' : '' }}" href="{{ route('pengunjung.dashboard') }}">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengunjung.catalog*') ? 'active' : '' }}" href="{{ route('pengunjung.catalog') }}">
                            <i class="fas fa-book me-1"></i>Katalog Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengunjung.extensions*') ? 'active' : '' }}" href="{{ route('pengunjung.extensions') }}">
                            <i class="fas fa-clock me-1"></i>Perpanjangan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengunjung.profile') ? 'active' : '' }}" href="{{ route('pengunjung.profile') }}">
                            <i class="fas fa-user me-1"></i>Profil
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" style="color: white;">
                            <div class="user-avatar me-2">
                                {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->nama ?? 'User' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('pengunjung.profile') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <div class="content-wrapper">
        <div class="container content-container-fixed">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>
