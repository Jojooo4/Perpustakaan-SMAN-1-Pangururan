<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Petugas') - Perpustakaan SMAN 1 Pangururan</title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0d3b66;
            --primary-soft: #1c5fa6;
            --secondary: #4aa0c9;
            --secondary-dark: #2b7cae;
            --surface: #f6f9ff;
            --surface-strong: rgba(255, 255, 255, 0.92);
            --accent: #87c0ff;
            --shadow: 0 20px 45px rgba(13, 59, 102, 0.15);
            --sidebar-width: 260px;
            --rounded: 1.25rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #0d3b66 0%, #1967a1 40%, #e5f2ff 100%);
            color: #0d1b2b;
            overflow-x: hidden;
            min-height: 100vh;
            position: relative;
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <title>@yield('title', 'Petugas') - Perpustakaan SMAN 1 Pangururan</title>
    
            <!-- Bootstrap 5.3 -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Font Awesome 6 -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <!-- Google Fonts -->
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
            <style>
                :root {
                    --navy: #081337;
                    --navy-light: #0f1d3c;
                    --navy-dark: #0a1634;
                    --accent: #4aa0c9;
                    --accent-2: #6bc8ff;
                    --gold: #ffc857;
                    --surface: #f8fbff;
                    --glass: rgba(255, 255, 255, 0.92);
                    --glass-strong: rgba(8, 19, 55, 0.12);
                    --shadow: 0 30px 60px rgba(4, 7, 25, 0.35);
                    --sidebar-width: 280px;
                    --rounded: 28px;
                }

                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }

                body {
                    font-family: 'Inter', system-ui, sans-serif;
                    background: linear-gradient(170deg, #0f3f87 0%, #0d4d92 50%, #06426e 100%);
                    min-height: 100vh;
                    color: #0b1e35;
                    overflow-x: hidden;
                    position: relative;
                    background-attachment: fixed;
                }

                body::before {
                    content: '';
                    position: fixed;
                    inset: 0;
                    background: radial-gradient(circle at 25% 15%, rgba(255, 255, 255, 0.25), transparent 40%),
                        radial-gradient(circle at 70% 0%, rgba(255, 255, 255, 0.12), transparent 40%);
                    pointer-events: none;
                    z-index: 0;
                }

                body::after {
                    content: '';
                    position: fixed;
                    inset: 0;
                    background: radial-gradient(circle at 65% 80%, rgba(21, 56, 112, 0.35), transparent 50%);
                    pointer-events: none;
                    z-index: 0;
                }

                .sidebar {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: var(--sidebar-width);
                    height: 100vh;
                    background:
                        linear-gradient(180deg, #0b2b48 0%, #0a2741 40%, #051d33 100%),
                        radial-gradient(circle at 0% 0%, rgba(255, 255, 255, 0.08), transparent 55%);
                    border-right: 1px solid rgba(0, 0, 0, 0.3);
                    padding-bottom: 2rem;
                    box-shadow: 10px 0 40px rgba(0, 0, 0, 0.7);
                    z-index: 1000;
                    display: flex;
                    flex-direction: column;
                }

                .sidebar-header {
                    padding: 1.8rem 1.6rem 2rem;
                    background: linear-gradient(180deg, #3f95ce 0%, #2a79b2 100%);
                    color: #ffffff;
                    text-align: center;
                    border-bottom: 0;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.55);
                }

                .sidebar-logo-circle {
                    width: 80px;
                    height: 80px;
                    margin: 0 auto 1rem;
                    border-radius: 50%;
                    border: 2px solid rgba(255, 255, 255, 0.7);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: rgba(255, 255, 255, 0.95);
                    box-shadow: 0 18px 35px rgba(0, 0, 0, 0.55);
                    padding: 0.5rem;
                }

                .sidebar-logo-img {
                    width: 100%;
                    height: 100%;
                    object-fit: contain;
                }

                .sidebar-header h4 {
                    font-size: 1.05rem;
                    letter-spacing: 0.18rem;
                    text-transform: uppercase;
                    margin-bottom: 0.25rem;
                }

                .sidebar-header p {
                    font-size: 0.8rem;
                    margin: 0;
                    opacity: 0.9;
                }

                .sidebar-separator {
                    height: 12px;
                    background: linear-gradient(180deg, #17456e 0%, #0d3558 100%);
                    box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.45);
                }

                .sidebar-menu {
                    margin-top: 0;
                    flex: 1;
                }

                .menu-item {
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                    padding: 0.85rem 1.6rem;
                    color: rgba(255, 255, 255, 0.9);
                    text-decoration: none;
                    transition: all 0.2s ease;
                    font-weight: 500;
                    border-left: 4px solid transparent;
                    margin: 0.25rem 0;
                    border-radius: 999px 0 0 999px;
                }

                .menu-item:hover {
                    background: linear-gradient(90deg, rgba(255, 255, 255, 0.14), rgba(255, 255, 255, 0));
                    border-left-color: rgba(255, 255, 255, 0.8);
                    color: #ffffff;
                    transform: translateX(2px);
                }

                .menu-item.active {
                    background: linear-gradient(90deg, rgba(255, 255, 255, 0.22), rgba(255, 255, 255, 0));
                    border-left-color: #ffffff;
                    color: #ffffff;
                    box-shadow: 6px 0 18px rgba(0, 0, 0, 0.45);
                }

                .menu-item i {
                    min-width: 22px;
                    font-size: 0.95rem;
                }

                .main-content {
                    margin-left: var(--sidebar-width);
                    min-height: 100vh;
                    padding-bottom: 3rem;
                    position: relative;
                    z-index: 1;
                }

                .top-navbar {
                    background: linear-gradient(120deg, rgba(251, 253, 255, 0.9), rgba(243, 247, 255, 0.9));
                    border-radius: 36px;
                    padding: 1.3rem 2.8rem;
                    margin: 1.25rem 2rem 0;
                    box-shadow: 0 20px 55px rgba(6, 16, 56, 0.3);
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    position: sticky;
                    top: 1rem;
                    z-index: 10;
                    border: 1px solid rgba(255, 255, 255, 0.8);
                    backdrop-filter: blur(18px);
                    -webkit-backdrop-filter: blur(18px);
                }

                .top-navbar h5 {
                    margin: 0;
                    font-weight: 700;
                    font-size: 1.05rem;
                    letter-spacing: 0.22rem;
                    text-transform: uppercase;
                    color: var(--navy-dark);
                }

                .pill-badge {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0.15rem 0.85rem;
                    border-radius: 999px;
                    font-size: 0.75rem;
                    font-weight: 600;
                    letter-spacing: 0.1rem;
                    color: white;
                    background: linear-gradient(120deg, var(--accent), var(--accent-2));
                    box-shadow: 0 8px 22px rgba(74, 160, 201, 0.35);
                }

                .user-menu {
                    display: flex;
                    align-items: center;
                    gap: 1.1rem;
                }

                .user-menu .dropdown-toggle {
                    display: flex;
                    align-items: center;
                    gap: 0.9rem;
                }

                .user-avatar {
                    width: 48px;
                    height: 48px;
                    border-radius: 50%;
                    background: linear-gradient(140deg, #4aa0c9, #1f6fb2);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #ffffff;
                    font-weight: 700;
                    text-transform: uppercase;
                    box-shadow: 0 18px 35px rgba(21, 90, 160, 0.45);
                }

                .user-meta small {
                    text-transform: uppercase;
                    letter-spacing: 0.18rem;
                    font-size: 0.7rem;
                    color: #8a9ab8;
                }

                .user-meta strong {
                    font-size: 1rem;
                    letter-spacing: 0.2rem;
                    text-transform: uppercase;
                    color: var(--navy-dark);
                }

                .user-menu .dropdown-toggle::after {
                    display: none;
                }

                .content-area {
                    padding: 0 2.5rem 3rem;
                    background: transparent;
                }

                .dashboard-shell {
                    margin: 2.4rem auto 2.5rem;
                    max-width: 1180px;
                    background: linear-gradient(135deg, rgba(255, 255, 255, 0.96), rgba(249, 253, 255, 0.98));
                    border-radius: 40px;
                    padding: 2.2rem 2.4rem 2.6rem;
                    box-shadow: 0 35px 80px rgba(3, 16, 43, 0.5);
                    border: 1px solid rgba(255, 255, 255, 0.9);
                    position: relative;
                    overflow: hidden;
                }

                .dashboard-shell::after {
                    content: '';
                    position: absolute;
                    inset: 0;
                    background: radial-gradient(circle at 15% 0%, rgba(255, 255, 255, 0.55), transparent 55%),
                        radial-gradient(circle at 85% 100%, rgba(66, 150, 222, 0.25), transparent 50%);
                    pointer-events: none;
                }

                .stat-card {
                    background: #ffffff;
                    border-radius: 22px;
                    padding: 1.75rem;
                    box-shadow: 0 20px 40px rgba(6, 8, 33, 0.08);
                    transition: transform 0.35s ease, box-shadow 0.35s ease;
                    border: 1px solid rgba(15, 43, 93, 0.08);
                }

                .stat-card:hover {
                    transform: translateY(-6px);
                    box-shadow: 0 30px 55px rgba(8, 18, 54, 0.15);
                }

                .stat-card .stat-icon {
                    width: 60px;
                    height: 60px;
                    border-radius: 20px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 1.35rem;
                    box-shadow: 0 12px 25px rgba(3, 7, 21, 0.25);
                }

                .stat-card h3 {
                    font-weight: 700;
                    font-size: 2.3rem;
                    color: var(--navy-dark);
                    margin-bottom: 0;
                }

                .stat-card p {
                    margin-bottom: 0.5rem;
                    color: #6b7b9f;
                    text-transform: uppercase;
                    font-size: 0.75rem;
                    letter-spacing: 0.25rem;
                }

                .dash-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                    gap: 1.6rem;
                    margin-top: 1.25rem;
                }

                .hero-card {
                    background: linear-gradient(135deg, #12325a 0%, #0f3158 40%, #0c2a4c 80%, #09213e 100%);
                    border-radius: 34px;
                    color: white;
                    padding: 2.6rem 3rem 2.8rem;
                    box-shadow: 0 30px 70px rgba(7, 23, 66, 0.55);
                    position: relative;
                    overflow: hidden;
                    border: 1px solid rgba(255, 255, 255, 0.35);
                    margin-bottom: 2.2rem;
                }

                .hero-card::after {
                    content: '';
                    position: absolute;
                    inset: 0;
                    background:
                        radial-gradient(circle at 15% 0%, rgba(255, 255, 255, 0.18), transparent 55%),
                        radial-gradient(circle at 18% 85%, rgba(0, 0, 0, 0.4), transparent 60%);
                    opacity: 0.9;
                    pointer-events: none;
                }

                .hero-card * {
                    position: relative;
                    z-index: 1;
                }

                .hero-badge {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.4rem;
                    padding: 0.25rem 0.9rem;
                    border-radius: 999px;
                    background: rgba(255, 255, 255, 0.2);
                    font-size: 0.75rem;
                    letter-spacing: 0.18rem;
                    text-transform: uppercase;
                }

                .hero-card h2 {
                    margin-top: 1.4rem;
                    font-size: 2.4rem;
                    font-weight: 700;
                }

                .hero-card p {
                    margin: 0.9rem 0 1.6rem;
                    color: rgba(233, 242, 255, 0.96);
                    max-width: 600px;
                    letter-spacing: 0.01rem;
                }

                .hero-actions {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 0.9rem;
                }

                .hero-actions .btn {
                    border-radius: 999px;
                    font-weight: 600;
                    padding: 0.9rem 1.6rem;
                    box-shadow: 0 12px 26px rgba(4, 7, 40, 0.5);
                    border: none;
                    text-transform: none;
                }

                .hero-actions .btn i {
                    margin-right: 0.45rem;
                }

                .btn-accent {
                    background: linear-gradient(135deg, #ffd54a, #ffb300);
                    color: #14213d;
                    box-shadow: 0 18px 40px rgba(255, 179, 0, 0.45);
                }

                .btn-accent-outline {
                    border: 1px solid rgba(255, 255, 255, 0.5);
                    background: rgba(255, 255, 255, 0.12);
                    color: #f5fbff;
                }

                .welcome-panel {
                    text-align: center;
                    background: #ffffff;
                    border-radius: 32px;
                    padding: 2.8rem 2rem;
                    box-shadow: 0 25px 50px rgba(8, 18, 54, 0.18);
                    border: 1px solid rgba(61, 115, 205, 0.1);
                    color: #11306b;
                }

                .welcome-panel i {
                    font-size: 3rem;
                    color: rgba(74, 160, 201, 0.8);
                }

                .welcome-panel h5 {
                    margin: 1rem 0 0.5rem;
                    font-weight: 700;
                    color: #0d1b34;
                }

                .welcome-panel p {
                    color: #5d6a8b;
                    opacity: 1;
                    margin-bottom: 0;
                }

                .icon-primary {
                    background: linear-gradient(135deg, #12224f, #0c3b7c);
                }

                .icon-secondary {
                    background: linear-gradient(135deg, #41c4ff, #1f84d1);
                }

                .icon-warning {
                    background: linear-gradient(135deg, #f59e0b, #ffc857);
                }

                @media (max-width: 992px) {
                    .top-navbar {
                        padding: 1rem 1.5rem;
                        flex-direction: column;
                        gap: 0.75rem;
                    }

                    .content-area {
                        padding: 2rem 1rem 3rem;
                    }
                }

                @media (max-width: 768px) {
                    .sidebar {
                        margin-left: calc(-1 * var(--sidebar-width));
                    }

                    .sidebar.show {
                        margin-left: 0;
                    }

                    .main-content {
                        margin-left: 0;
                    }

                    .hero-card,
                    .dashboard-shell {
                        padding: 2rem;
                    }

                    .top-navbar {
                        margin-left: 1rem;
                        margin-right: 1rem;
                    }
                }
            </style>
    
            @stack('styles')
        </head>
        <body>
            <div class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <div class="sidebar-logo-circle">
                        <img src="{{ asset('assets/logo-website.png') }}" alt="Logo SMAN 1 Pangururan" class="sidebar-logo-img">
                    </div>
                    <h4>PERPUSTAKAAN</h4>
                    <p>SMAN 1 Pangururan</p>
                </div>
                <div class="sidebar-separator"></div>
                <div class="sidebar-menu">
                    <a href="{{ route('petugas.dashboard') }}" class="menu-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="{{ route('petugas.buku.index') }}" class="menu-item {{ request()->routeIs('petugas.buku.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Manajemen Buku
                    </a>
                    <a href="{{ route('petugas.transaksi.index') }}" class="menu-item {{ request()->routeIs('petugas.transaksi.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i> Pinjam & Kembali
                    </a>
                    <a href="{{ route('petugas.perpanjangan.index') }}" class="menu-item {{ request()->routeIs('petugas.perpanjangan.*') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i> Perpanjangan
                        @php
                            $pendingPerpanjanganCount = \App\Models\RequestPerpanjangan::where('status', 'pending')->count();
                        @endphp
                        @if($pendingPerpanjanganCount > 0)
                            <span class="badge bg-warning text-dark ms-2" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">{{ $pendingPerpanjanganCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('petugas.denda.index') }}" class="menu-item {{ request()->routeIs('petugas.denda.*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave"></i> Laporan Denda
                    </a>
                    <a href="{{ route('petugas.pengelolaan.review') }}" class="menu-item {{ request()->routeIs('petugas.pengelolaan.review') ? 'active' : '' }}">
                        <i class="fas fa-star"></i> Review Ulasan
                    </a>
                    <a href="{{ route('petugas.request-peminjaman.index') }}" class="menu-item {{ request()->routeIs('petugas.request-peminjaman.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i> Request Peminjaman
                        @php
                            $pendingCount = \App\Models\RequestPeminjaman::where('status', 'pending')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="badge bg-warning text-dark ms-2" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('petugas.profile') }}" class="menu-item {{ request()->routeIs('petugas.profile') ? 'active' : '' }}">
                        <i class="fas fa-user-cog"></i> Pengaturan Profil
                    </a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-item">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <div class="main-content">
                <div class="top-navbar">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-link text-dark d-md-none" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
                        </div>
                    </div>
                    <div class="user-menu">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
@php
    use Illuminate\Support\Facades\Storage;
    $navUser = auth()->user();
    $navAvatarUrl = $navUser && $navUser->foto_profil ? Storage::url($navUser->foto_profil) : null;
    $navInitial = strtoupper(substr($navUser->nama ?? 'P', 0, 1));
@endphp
                                <div class="user-avatar" style="{{ $navAvatarUrl ? 'background-image: url(' . $navAvatarUrl . '); background-size: cover; background-position: center;' : '' }}">
                                    @unless($navAvatarUrl)
                                        {{ $navInitial }}
                                    @endunless
                                </div>
                                <div class="d-none d-md-block user-meta">
                                    <small class="d-block">Petugas</small>
                                    <strong class="d-block">{{ auth()->user()->nama ?? 'Petugas' }}</strong>
                                </div>
                                <i class="fas fa-chevron-down ms-2" style="font-size: 0.8rem; color: #0d2a4f;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('petugas.profile') }}"><i class="fas fa-user me-2"></i> Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="content-area">
                    <div class="dashboard-shell">
                        @yield('content')
                    </div>
                </div>
            </div>
            
            <!-- Global Notification Modal -->
            @if(session('success') || session('error') || $errors->any())
            <div class="modal fade" id="notificationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                        @if(session('success'))
                        <!-- Success Notification -->
                        <div class="modal-header border-0" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 2rem;">
                            <div class="w-100 text-center">
                                <div class="notification-icon mx-auto mb-3" style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-check-circle" style="font-size: 2.5rem; color: white;"></i>
                                </div>
                                <h4 class="text-white fw-bold mb-0">Berhasil!</h4>
                            </div>
                        </div>
                        <div class="modal-body text-center" style="padding: 2rem;">
                            <p class="mb-0" style="font-size: 1.1rem;">{{ session('success') }}</p>
                        </div>
                        @elseif(session('error'))
                        <!-- Error Notification -->
                        <div class="modal-header border-0" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 2rem;">
                            <div class="w-100 text-center">
                                <div class="notification-icon mx-auto mb-3" style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-exclamation-circle" style="font-size: 2.5rem; color: white;"></i>
                                </div>
                                <h4 class="text-white fw-bold mb-0">Gagal!</h4>
                            </div>
                        </div>
                        <div class="modal-body text-center" style="padding: 2rem;">
                            <p class="mb-0" style="font-size: 1.1rem;">{{ session('error') }}</p>
                        </div>
                        @elseif($errors->any())
                        <!-- Validation Errors -->
                        <div class="modal-header border-0" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); padding: 2rem;">
                            <div class="w-100 text-center">
                                <div class="notification-icon mx-auto mb-3" style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-exclamation-triangle" style="font-size: 2.5rem; color: white;"></i>
                                </div>
                                <h4 class="text-white fw-bold mb-0">Perhatian!</h4>
                            </div>
                        </div>
                        <div class="modal-body" style="padding: 2rem;">
                            <ul class="text-start mb-0">
                                @foreach($errors->all() as $error)
                                    <li style="margin-bottom: 0.5rem;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="modal-footer border-0" style="padding: 1rem 2rem; background: #f8f9fa;">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.6rem 2rem;">
                                <i class="fas fa-check me-2"></i>OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                document.getElementById('sidebarToggle')?.addEventListener('click', function() {
                    document.getElementById('sidebar').classList.toggle('show');
                });

                // Auto-show notification modal
                document.addEventListener('DOMContentLoaded', function() {
                    const notificationModal = document.getElementById('notificationModal');
                    if (notificationModal) {
                        const modal = new bootstrap.Modal(notificationModal);
                        modal.show();
                    }
                });
            </script>
    
            @stack('scripts')
        </body>
        </html>