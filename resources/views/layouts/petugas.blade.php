<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Petugas - @yield('title', 'Dashboard')</title>

    {{-- BOOTSTRAP & ICONS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f5f7fb;
        }

        .sidebar {
            background:#063852;
            color:#fff;
            min-height:100vh;
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
            color:#e6f7fb;
            font-size: .9rem;
        }

        .sidebar .nav-link i {
            margin-right: .4rem;
        }

        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.18);
            border-radius: .35rem;
            font-weight: 600;
        }

        main {
            background: #f5f7fb;
        }
    </style>

    @yield('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#05445E">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('petugas.dashboard') }}">Sistem Perpustakaan - Petugas</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPetugas">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navPetugas">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3 text-end text-white small d-none d-md-block">
                    <div>Petugas Perpustakaan</div>
                    <div class="fw-semibold">
                        {{ auth()->user()->nama ?? auth()->user()->username }}
                    </div>
                </li>
                <li class="nav-item d-none d-md-block me-2">
                    <a href="#" class="btn btn-outline-light btn-sm">
                        Petugas <span class="fw-semibold">Profile</span>
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="{{ url('/') }}">Website</a>
                </li>
                <li class="nav-item ms-md-2">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-outline-light" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        {{-- SIDEBAR --}}
        <aside class="col-12 col-md-3 col-lg-2 p-0 sidebar">
            <div class="p-3">
                <h5 class="mb-3 fw-semibold">PANEL PETUGAS</h5>

                <div class="sidebar-title">Utama</div>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"
                           href="{{ route('petugas.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-bookshelf"></i> Manajemen Buku
                        </a>
                    </li>
                </ul>

                <div class="sidebar-title">Transaksi</div>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-arrow-left-right"></i> Pinjam &amp; Kembali
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-arrow-repeat"></i> Permintaan Perpanjangan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-receipt"></i> Laporan Denda
                        </a>
                    </li>
                </ul>

                <div class="sidebar-title">Pengelolaan</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-people"></i> Manajemen Pengguna
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        {{-- KONTEN UTAMA --}}
        <main class="col-12 col-md-9 col-lg-10 py-4">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')
</body>
</html>
