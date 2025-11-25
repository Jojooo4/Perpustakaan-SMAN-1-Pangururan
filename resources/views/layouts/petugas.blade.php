<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Petugas - @yield('title', 'Dashboard')</title>

    {{-- BOOTSTRAP 5 & ICONS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
        }

        /* Sidebar Styling */
        .sidebar {
            background: #063852;
            color: #fff;
            min-height: 100vh;
        }
        .sidebar .sidebar-title {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .12em;
            opacity: .7;
            margin-top: 1rem;
            margin-bottom: .3rem;
        }
        .sidebar .nav-link {
            color: #e6f7fb;
            font-size: .9rem;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-weight: 500;
        }
        .sidebar .nav-link i {
            margin-right: .5rem;
        }

        /* Navbar Profile Styling */
        .profile-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .profile-wrapper:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .profile-name {
            margin-right: 12px;
            color: white;
            text-align: right;
            line-height: 1.2;
        }
        .profile-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>

    @yield('styles')
</head>
<body>

{{-- NAVBAR ATAS --}}
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background:#05445E; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <div class="container-fluid">
        
        {{-- PERUBAHAN DISINI: Logo diganti menjadi "Petugas" --}}
        <a class="navbar-brand fw-bold" href="{{ route('petugas.dashboard') }}">
            <i class="bi bi-person-badge-fill me-2"></i>Petugas
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPetugas">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navPetugas">
            <ul class="navbar-nav ms-auto align-items-center">
                {{-- Profile Section (Klik untuk Modal) --}}
                <li class="nav-item me-3 d-none d-md-block">
                    <div class="profile-wrapper" data-bs-toggle="modal" data-bs-target="#profileModal">
                        <div class="profile-name">
                            <div style="font-size: 0.75rem; opacity: 0.8;">Petugas</div>
                            <div class="fw-semibold">{{ auth()->user()->nama ?? auth()->user()->username }}</div>
                        </div>
                        <img src="{{ asset('images/foto-profil.jpg') }}" alt="Foto" class="profile-image">
                    </div>
                </li>
                
                {{-- Menu Mobile --}}
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="{{ route('petugas.profile') }}">Profil Saya</a>
                </li>
                <li class="nav-item ms-md-2">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger text-white border-white" type="submit">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- MODAL POP-UP PROFIL --}}
<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center pt-0 pb-4">
        <img src="{{ asset('images/foto-profil.jpg') }}" alt="Foto" class="rounded-circle mb-3 shadow-sm" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #f8f9fa;">
        <h6 class="fw-bold mb-0">{{ auth()->user()->nama ?? 'User' }}</h6>
        <p class="text-muted small mb-3">{{ auth()->user()->nip ?? 'NIP Tidak Tersedia' }}</p>
        
        <div class="d-grid">
            <a href="{{ route('petugas.profile') }}" class="btn btn-primary btn-sm rounded-pill">
                Selengkapnya
            </a>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- LAYOUT UTAMA --}}
<div class="container-fluid">
    <div class="row">
        {{-- SIDEBAR KIRI --}}
        <aside class="col-12 col-md-3 col-lg-2 p-0 sidebar collapse d-md-block" id="sidebarMenu">
            <div class="p-3">
                <h5 class="mb-4 fw-bold px-2 mt-2" style="letter-spacing: 1px;">MENU</h5>

                <div class="sidebar-title px-2">Utama</div>
                <nav class="nav flex-column mb-3">
                    <a class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" href="{{ route('petugas.dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                    <a class="nav-link" href="#"><i class="bi bi-journal-album"></i> Data Buku</a>
                    <a class="nav-link" href="#"><i class="bi bi-people-fill"></i> Data Anggota</a>
                </nav>

                <div class="sidebar-title px-2">Transaksi</div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="#"><i class="bi bi-arrow-left-right"></i> Peminjaman</a>
                    <a class="nav-link" href="#"><i class="bi bi-arrow-counterclockwise"></i> Pengembalian</a>
                </nav>
            </div>
        </aside>

        {{-- KONTEN KANAN --}}
        <main class="col-12 col-md-9 col-lg-10 py-4 px-4">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>