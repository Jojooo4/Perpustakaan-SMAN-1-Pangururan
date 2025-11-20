<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin - @yield('title', 'Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
    .admin-sidebar { min-height: 100vh; background: #0f1724; color: #e6eef6; }
    .admin-sidebar a { color: #cfe8ff; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Website</a></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
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
      <aside class="col-12 col-md-3 col-lg-2 p-0 admin-sidebar">
        <div class="p-3">
          <h5 class="mb-3">Admin</h5>
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Kelola Buku</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Pengguna</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Laporan</a></li>
          </ul>
        </div>
      </aside>

      <main class="col-12 col-md-9 col-lg-10 py-4">
        @yield('content')
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
