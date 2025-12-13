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
            --primary: #2b3458;
            --primary-dark: #232a4a;
            --accent: #4aa0c9;
            --accent-dark: #2b7cae;
            --light: #fbf9e7;
            --light-blue: #c7e1f2;
            --dark: #2b3458;
            --sidebar-width: 280px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            font-size: 16px;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
            overflow-x: hidden;
            color: #0b1e35;
        }

        /* Background hanya untuk area konten (bukan footer) */
        .page-bg {
            background:
                linear-gradient(
                    to bottom,
                    rgba(255, 255, 255, 0.80) 0%,
                    rgba(255, 255, 255, 0.65) 35%,
                    rgba(14, 25, 64, 0.18) 55%,
                    rgba(14, 25, 64, 0.6) 100%
                ),
                url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1600&q=80') center top/cover no-repeat fixed;
            min-height: 100vh;
        }
        
        /* Sidebar Overlay Backdrop */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        /* Sidebar - Hidden by default */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--dark);
            box-shadow: 4px 0 20px rgba(0,0,0,0.2);
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar.show {
            transform: translateX(0);
        }
        
        .sidebar-header {
            padding: 2.5rem 1.5rem 2rem;
            background: var(--primary);
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .sidebar-logo-circle {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            padding: 0.5rem;
        }

        .sidebar-logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .sidebar-logo-circle i {
            font-size: 1.8rem;
            color: #ffffff;
        }

        .sidebar-header h4 {
            font-size: 1.05rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: 0.2rem;
            text-transform: uppercase;
        }

        .sidebar-header p {
            font-size: 0.8rem;
            margin: 0.2rem 0 0;
            opacity: 0.9;
            letter-spacing: 0.1rem;
        }
        
        .sidebar-menu {
            padding: 1.2rem 0 1.8rem;
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }
        
        .menu-section {
            padding: 0.75rem 1.75rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255,255,255,0.5);
            margin-top: 1rem;
            font-weight: 600;
        }

        .menu-spacer {
            height: 0.6rem;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 1.6rem;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            margin: 0.2rem 0;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: var(--accent);
            color: #ffffff;
            transform: translateX(3px);
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: var(--accent);
            color: #ffffff;
            font-weight: 600;
        }
        
        .menu-item i {
            min-width: 22px;
            margin-right: 4px;
            font-size: 0.95rem;
        }
        
        /* Main Content - Full Width */
        .main-content {
            min-height: 100vh;
            padding: 0;
            display: flex;
            flex-direction: column;
        }
        
        /* Top Navbar with Hamburger */
        .top-navbar {
            background: var(--primary);
            padding: 0.9rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            position: sticky;
            top: 0;
            z-index: 1030;
            width: 100%;
        }

        .top-navbar-pill {
            background: transparent;
            border-radius: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            box-shadow: none;
            width: 100%;
        }

        .hamburger-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            border-radius: 8px;
        }

        .hamburger-btn:hover {
            background: rgba(255, 255, 255, 0.14);
        }

        .hamburger-btn i {
            font-size: 1.3rem;
            color: #ffffff;
        }

        .top-navbar-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .top-navbar-title h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.1rem;
            color: #ffffff;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .user-dropdown-toggle {
            background: transparent;
            border: none;
            padding: 0.35rem 0.4rem;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.95);
            transition: background 0.2s ease;
        }

        .user-dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.14);
        }

        .user-dropdown-toggle i {
            font-size: 0.95rem;
        }

        .user-dropdown-menu {
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
            overflow: hidden;
            min-width: 190px;
        }

        .user-dropdown-menu .dropdown-item {
            padding: 0.7rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .user-dropdown-menu .dropdown-item i {
            width: 18px;
            text-align: center;
            opacity: 0.75;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ffffff;
            color: var(--primary);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
        }

        .user-details {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-details small {
            color: rgba(255, 255, 255, 0.78);
            font-size: 0.75rem;
        }

        .user-details strong {
            font-size: 0.95rem;
            color: #ffffff;
        }
        
        /* Content Area */
        .content-area {
            padding: 2rem;
            min-height: auto;
            flex: 0 0 auto;
        }

        /* Footer */
        .visitor-footer {
            background: var(--primary);
            color: rgba(255, 255, 255, 0.88);
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            backdrop-filter: none;
            padding: 0;
        }

        .visitor-footer-top {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.6rem 2rem 1.1rem;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.8rem;
            justify-items: center;
            text-align: center;
        }

        .visitor-footer-title {
            color: #ffffff;
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            margin: 0 0 0.85rem;
            letter-spacing: 0.14em;
            text-align: center;
        }

        .visitor-footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
            align-items: center;
        }

        .visitor-footer-links a {
            color: rgba(255, 255, 255, 0.78);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .visitor-footer-links a:hover {
            color: #ffffff;
        }

        .visitor-footer-social {
            display: flex;
            gap: 0.6rem;
            align-items: center;
            justify-content: center;
        }

        .visitor-footer-social a {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            text-decoration: none;
            transition: background 0.2s ease, transform 0.2s ease, border-color 0.2s ease;
        }

        .visitor-footer-social a:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.28);
            transform: translateY(-1px);
        }

        .visitor-footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(0, 0, 0, 0.12);
            padding: 0.9rem 2rem;
        }

        .visitor-footer-bottom-inner {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .visitor-footer-bottom-inner a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .visitor-footer-bottom-inner a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .visitor-footer {
                padding: 0;
            }

            .visitor-footer-top {
                padding: 1.25rem 1rem 0.9rem;
                grid-template-columns: 1fr;
                gap: 1.25rem;
                text-align: center;
            }

            .visitor-footer-title {
                margin-bottom: 0.9rem;
            }

            .visitor-footer-links a {
                font-size: 0.95rem;
            }

            .visitor-footer-bottom {
                padding: 0.85rem 1rem;
            }
        }
        
        .content-container-fixed {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }
        
        /* Cards */
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
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        /* Alerts */
        .alert {
            border-radius: 10px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .content-area {
                padding: 1rem;
            }

            .top-navbar {
                padding: 0.85rem 1rem;
            }

            .top-navbar-pill {
                padding: 0;
            }

            .user-details {
                display: none !important;
            }
        }

        @media (max-width: 576px) {
            .content-container-fixed {
                max-width: 100%;
                padding: 0 15px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Popup -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo-circle">
                <img src="{{ asset('assets/logo-website.png') }}" alt="Logo SMAN 1 Pangururan" class="sidebar-logo-img">
            </div>
            <h4>PERPUSTAKAAN</h4>
            <p>SMAN 1 Pangururan</p>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-section">Utama</div>
            <a href="{{ route('pengunjung.dashboard') }}" class="menu-item {{ request()->routeIs('pengunjung.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('pengunjung.catalog') }}" class="menu-item {{ request()->routeIs('pengunjung.catalog*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Katalog Buku
            </a>

            <div class="menu-section">Aktivitas</div>
            <a href="{{ route('pengunjung.my-requests') }}" class="menu-item {{ request()->routeIs('pengunjung.my-requests') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Request Saya
            </a>
            <a href="{{ route('pengunjung.extensions') }}" class="menu-item {{ request()->routeIs('pengunjung.extensions*') ? 'active' : '' }}">
                <i class="fas fa-clock"></i> Perpanjangan
            </a>
            <a href="{{ route('pengunjung.history') }}" class="menu-item {{ request()->routeIs('pengunjung.history') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Riwayat
            </a>

            <div class="menu-section">Pengaturan</div>
            <a href="{{ route('pengunjung.profile') }}" class="menu-item {{ request()->routeIs('pengunjung.profile') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Profil
            </a>
            
            <div class="menu-spacer"></div>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-item">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <div class="page-bg">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <div class="top-navbar">
                <div class="top-navbar-pill">
                    <div class="top-navbar-title">
                        <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle Menu">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h5>Menu</h5>
                    </div>

                    <div class="user-info">
                        <div class="dropdown">
                            <div class="user-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
@php
    use Illuminate\Support\Facades\Storage;
    $navUser = auth()->user();
    $navAvatarUrl = $navUser && $navUser->foto_profil ? Storage::url($navUser->foto_profil) : null;
    $navInitial = strtoupper(substr($navUser->nama ?? 'U', 0, 1));
@endphp
                                <div class="user-avatar" style="{{ $navAvatarUrl ? 'background-image: url(' . $navAvatarUrl . '); background-size: cover; background-position: center;' : '' }}">
                                    @unless($navAvatarUrl)
                                        {{ $navInitial }}
                                    @endunless
                                </div>
                                <div class="user-details d-none d-md-flex">
                                    <small>Pengunjung</small>
                                    <strong>{{ auth()->user()->nama ?? 'User' }}</strong>
                                </div>
                                <button class="user-dropdown-toggle" type="button" aria-label="Buka menu pengguna">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>

                            <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('pengunjung.profile') }}">
                                        <i class="fas fa-user"></i>
                                        Profil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="content-area">
                <div class="content-container-fixed">
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
        </div>
    </div>

    <footer class="visitor-footer">
        <div class="visitor-footer-top">
            <div>
                <div class="visitor-footer-title">Link Terkait</div>
                <ul class="visitor-footer-links">
                    <li><a href="{{ route('pengunjung.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('pengunjung.catalog') }}">Katalog Buku</a></li>
                    <li><a href="{{ route('pengunjung.history') }}">Riwayat</a></li>
                </ul>
            </div>

            <div>
                <div class="visitor-footer-title">Akses Cepat</div>
                <ul class="visitor-footer-links">
                    <li><a href="{{ route('pengunjung.my-requests') }}">Request Saya</a></li>
                    <li><a href="{{ route('pengunjung.extensions') }}">Perpanjangan</a></li>
                    <li><a href="{{ route('pengunjung.profile') }}">Profil</a></li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                </ul>
            </div>

            <div>
                <div class="visitor-footer-title">Sosial Media</div>
                <div class="visitor-footer-social">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>

        <div class="visitor-footer-bottom">
            <div class="visitor-footer-bottom-inner">
                Copyright ©{{ date('Y') }} All rights reserved | Perpustakaan SMAN 1 Pangururan
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Open sidebar
        function openSidebar() {
            sidebar.classList.add('show');
            sidebarOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        // Close sidebar
        function closeSidebar() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Toggle sidebar
        hamburgerBtn.addEventListener('click', function() {
            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        // Close when clicking overlay
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Close when clicking menu item (except logout which needs to submit)
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                if (!this.getAttribute('onclick')) {
                    closeSidebar();
                }
            });
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                closeSidebar();
            }
        });
        
        // Auto-hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>
