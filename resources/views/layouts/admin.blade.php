<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Perpustakaan SMAN 1 Pangururan</title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2b3458;      /* Navy - matches homepage */
            --primary-dark: #232a4a;  /* Darker navy */
            --accent: #4aa0c9;        /* Blue accent */
            --accent-dark: #2b7cae;   /* Deeper blue */
            --light: #fbf9e7;         /* Cream */
            --light-blue: #c7e1f2;    /* Light blue */
            --dark: #2b3458;
            --sidebar-width: 260px;
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
            background:
                radial-gradient(circle at 25% 15%, rgba(255, 255, 255, 0.25), transparent 40%),
                radial-gradient(circle at 70% 0%, rgba(255, 255, 255, 0.12), transparent 45%);
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
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background:
                linear-gradient(180deg, #0b2b48 0%, #0a2741 40%, #051d33 100%),
                radial-gradient(circle at 0% 0%, rgba(255, 255, 255, 0.08), transparent 55%);
            border-right: 1px solid rgba(0, 0, 0, 0.3);
            padding-bottom: 2rem;
            box-shadow: 10px 0 40px rgba(0, 0, 0, 0.7);
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
        }

        .sidebar::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
        }
        
            .sidebar-header {
                padding: 2.5rem 1.5rem 2.1rem;
                background: linear-gradient(135deg, #185a99, #1e6fb4 55%, #174579);
                color: white;
                text-align: center;
                border-bottom: 1px solid rgba(255,255,255,0.15);
                box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45);
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

            .sidebar-logo-circle i {
                font-size: 1.8rem;
                color: #ffffff;
            }

            .sidebar-header h4 {
                font-size: 1.05rem;
                font-weight: 800;
                margin: 0;
                letter-spacing: 0.22rem;
                text-transform: uppercase;
            }

            .sidebar-header p {
                font-size: 0.8rem;
                margin: 0.2rem 0 0;
                opacity: 0.9;
                letter-spacing: 0.12rem;
            }
        
        .sidebar-menu {
            padding: 1.2rem 0 1.8rem;
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }
        
        .menu-section {
            padding: 0.75rem 1.75rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: rgba(255,255,255,0.6);
            margin-top: 1rem;
        }

        .menu-spacer {
            height: 0.6rem;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 1.6rem;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            margin: 0.25rem 0;
            border-radius: 999px 0 0 999px;
        }

        .menu-item:hover {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.16), rgba(255, 255, 255, 0));
            border-left-color: rgba(255, 255, 255, 0.8);
            color: #ffffff;
            transform: translateX(2px);
        }

        .menu-item.active {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.24), rgba(255, 255, 255, 0));
            border-left-color: #ffffff;
            color: #ffffff;
            box-shadow: 6px 0 18px rgba(0, 0, 0, 0.45);
        }
        
        .menu-item i {
            min-width: 22px;
            margin-right: 4px;
            font-size: 0.95rem;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 0;
            background: transparent;
            position: relative;
            z-index: 1;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: transparent;
            padding: 1.1rem 2rem 0;
            border-bottom: none;
            position: relative;
            z-index: 10;
        }

        .top-navbar-pill {
            background: linear-gradient(120deg, rgba(251, 253, 255, 0.96), rgba(243, 247, 255, 0.98));
            border-radius: 32px;
            padding: 1.1rem 2.4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.25rem;
            color: #0b1e35;
            box-shadow: 0 22px 55px rgba(6, 16, 56, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            position: relative;
            z-index: 20;
        }

        .top-navbar-copy {
            line-height: 1.25;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .top-navbar-copy h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.22rem;
            text-transform: uppercase;
            color: #081337;
        }

        .top-navbar-copy small {
            font-size: 0.75rem;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            margin-top: 0.2rem;
            color: #8a9ab8;
        }

        .user-pill {
            display: flex;
            align-items: center;
            position: relative;
            z-index: 30;
        }

        .user-pill .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 1.1rem;
        }

        /* Ensure user dropdown overlays content like search inputs */
        .dropdown-menu {
            z-index: 2000; /* above DataTables and inputs */
            position: absolute;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(140deg, #4aa0c9, #1f6fb2);
            color: #ffffff;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.6);
            background-size: cover;
            background-position: center;
            margin-left: -6px;
            box-shadow: 0 14px 30px rgba(7, 54, 109, 0.55);
        }

        .user-pill-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-pill-info small {
            color: #8a9ab8;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            font-size: 0.7rem;
        }

        .user-pill-info strong {
            font-size: 1rem;
            color: #081337;
        }

        .user-pill i {
            font-size: 0.8rem;
            color: #8a9ab8;
        }
        
        /* Content Area */
        .content-area {
            padding: 2rem;
            background: transparent;
            min-height: calc(100vh - 110px);
        }
        
        /* Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 6px 22px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .icon-primary { background: rgba(74, 160, 201, 0.1); color: var(--accent); }
        .icon-secondary { background: rgba(199, 225, 242, 0.3); color: var(--accent-dark); }
        .icon-success { background: rgba(40, 167, 69, 0.1); color: #28a745; }
        .icon-warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background: var(--accent-dark);
            border-color: var(--accent-dark);
        }
        
        /* Table */
        .table-custom {
            background: white;
            border-Radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .table-custom thead {
            background: var(--dark);
            color: white;
        }
        
        /* Responsive */
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
            
            .content-area {
                padding: 1rem;
            }

            .top-navbar {
                padding: 1rem;
            }

            .top-navbar-pill {
                flex-direction: column;
                align-items: flex-start;
            }

            .top-navbar-copy {
                width: 100%;
                justify-content: flex-start;
            }

            .user-pill {
                width: 100%;
                justify-content: space-between;
            }
        }
        
        /* Badges */
        .badge-status {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 500;
        }
        
        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
    
    @stack('styles')
</head>
<body>
@php
    use Illuminate\Support\Facades\Storage;
    $navUser = auth()->user();
    $navAvatarUrl = $navUser && $navUser->foto_profil ? Storage::url($navUser->foto_profil) : null;
    $navInitial = strtoupper(substr($navUser->nama ?? 'A', 0, 1));
@endphp
    <!-- Sidebar -->
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
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('buku.index') }}" class="menu-item {{ request()->routeIs('buku.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Manajemen Buku
            </a>

            <div class="menu-section">Transaksi</div>
            <a href="{{ route('transaksi.index') }}" class="menu-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt"></i> Pinjam & Kembali
            </a>
            <a href="{{ route('perpanjangan.index') }}" class="menu-item {{ request()->routeIs('perpanjangan.*') ? 'active' : '' }}">
                <i class="fas fa-clock"></i> Permintaan Perpanjangan
            </a>
            <a href="{{ route('denda.index') }}" class="menu-item {{ request()->routeIs('denda.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Laporan Denda
            </a>
            <a href="{{ route('admin.request-peminjaman.index') }}" class="menu-item {{ request()->routeIs('admin.request-peminjaman.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i> Request Peminjaman
                @php
                    $pendingCount = \App\Models\RequestPeminjaman::where('status', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-warning text-dark ms-2" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">{{ $pendingCount }}</span>
                @endif
            </a>

            <div class="menu-section">Pengelolaan</div>
            <a href="{{ route('pengelolaan.pengguna') }}" class="menu-item {{ request()->routeIs('pengelolaan.pengguna') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Manajemen Pengguna
            </a>
            <a href="{{ route('pengelolaan.review') }}" class="menu-item {{ request()->routeIs('pengelolaan.review') ? 'active' : '' }}">
                <i class="fas fa-star"></i> Review & Ulasan
            </a>
            <a href="{{ route('admin.log-aktivitas') }}" class="menu-item {{ request()->routeIs('admin.log-aktivitas') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Log Aktivitas
            </a>
            <div class="menu-spacer"></div>
            <div class="menu-section">Pengaturan</div>
            <a href="{{ route('profil.index') }}" class="menu-item {{ request()->routeIs('profil.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> Pengaturan Profil
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
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="top-navbar-pill">
                <div class="top-navbar-copy">
                    <button class="btn btn-link text-white d-md-none" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
                        <small></small>
                    </div>
                </div>

                <div class="user-pill dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="user-avatar" style="{{ $navAvatarUrl ? 'background-image: url(' . $navAvatarUrl . ');' : '' }}">
                            @unless($navAvatarUrl)
                                {{ $navInitial }}
                            @endunless
                        </div>
                        <div class="user-pill-info">
                            <small>Admin</small>
                            <strong>{{ auth()->user()->nama ?? 'Administrator' }}</strong>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profil.index') }}"><i class="fas fa-user me-2"></i> Profil</a></li>
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
        
        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
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
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle for mobile
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