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
            --primary: #3f6bff;
            --secondary: #dbe4ff;
            --dark: #0b1b4c;
            --light: #f7f8ff;
            --sidebar-width: 260px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #f6f7ff 0%, #eef2ff 60%, #dfe7ff 100%);
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0d1f4c, #14245d 70%, #16286f);
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
        }
        
            .sidebar-header {
                padding: 1.75rem 1rem;
                background: linear-gradient(135deg, #3f6bff, #5f84ff 60%, #2d3f94);
                color: white;
                text-align: center;
                border-bottom: 1px solid rgba(255,255,255,0.3);
            }

            .sidebar-header h4 {
                font-size: 1rem;
                font-weight: 700;
                margin: 0;
            }

            .sidebar-header p {
                font-size: 0.8rem;
                margin: 0;
                opacity: 0.85;
            }
        
        .sidebar-menu {
            padding: 1rem 0;
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
            height: 0.5rem;
        }

        .menu-item {
            display: block;
            padding: 0.9rem 1.5rem;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: rgba(255,255,255,0.5);
        }

        .menu-item.active {
            background: rgba(255,255,255,0.25);
            color: white;
            border-left-color: rgba(255,255,255,0.9);
        }
        
        .menu-item i {
            width: 20px;
            margin-right: 10px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 0;
            background: transparent;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: transparent;
            padding: 1rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .top-navbar-pill {
            background: linear-gradient(135deg, #3672ff, #5e95ff 70%, #849dff);
            border-radius: 28px;
            padding: 0.9rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.25rem;
            color: #fff;
            box-shadow: 0 20px 40px rgba(18, 43, 115, 0.25);
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
            font-size: 1.25rem;
        }

        .top-navbar-copy small {
            font-size: 0.75rem;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            margin-top: 0.2rem;
            color: rgba(255,255,255,0.75);
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 1.8rem;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.35);
            background-size: cover;
            background-position: center;
            margin-left: -10px;
        }

        .user-pill-info {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .user-pill-info small {
            color: rgba(255,255,255,0.8);
            letter-spacing: 0.35em;
            text-transform: uppercase;
            font-size: 0.7rem;
        }

        .user-pill-info strong {
            font-size: 1rem;
            color: #fff;
        }

        .user-pill i {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.8);
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
        
        .icon-primary { background: rgba(235, 69, 95, 0.1); color: var(--primary); }
        .icon-secondary { background: rgba(186, 215, 233, 0.3); color: #5a9cc2; }
        .icon-success { background: rgba(40, 167, 69, 0.1); color: #28a745; }
        .icon-warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background: #c93551;
            border-color: #c93551;
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
            <h4><i class="fas fa-book-reader"></i> PERPUSTAKAAN</h4>
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
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
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
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
        
        // Auto-hide alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>