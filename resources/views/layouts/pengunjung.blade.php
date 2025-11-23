<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Pengunjung - @yield('title', 'Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: Poppins, system-ui, sans-serif; }
    /* Navbar custom styles using palette color BAD7E9 */
    .navbar-custom { background: #BAD7E9; }
    .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: #2B3467 !important; font-weight:600; }
    .navbar-custom .nav-link:hover{ color: #EB455F !important; }
    .navbar-custom .btn-logout{ background: transparent; border: 1px solid rgba(43,52,103,0.08); color: #2B3467; }
    .navbar-avatar{ width:34px; height:34px; object-fit:cover; border-radius:50%; border:2px solid rgba(255,255,255,0.4); }
    .navbar-profile{ display:inline-flex; align-items:center; gap:8px; padding:6px 10px; border-radius:8px; background: rgba(43,52,103,0.02); }
    @media (max-width:575px){ .navbar-profile span{ display:none; } }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('pengunjung.dashboard') }}">Perpustakaan</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Website</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('pengunjung.katalog') ?? '#' }}">Katalog</a></li>
        </ul>
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item me-2">
            <a href="{{ route('pengunjung.profile') ?? '#' }}" class="nav-link navbar-profile text-decoration-none">
              <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama ?? auth()->user()->username) }}&background=EB455F&color=fff&size=64" alt="avatar" class="navbar-avatar">
              <span>{{ auth()->user()->nama ?? auth()->user()->username }}</span>
            </a>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" class="m-0">
              @csrf
              <button class="btn btn-sm btn-logout">Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <main class="container py-4">
    @yield('content')
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
