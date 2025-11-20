<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Petugas - @yield('title', 'Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style> body { font-family: Poppins, system-ui, sans-serif; } .sidebar { background:#063852; color:#fff; min-height:100vh; } .sidebar a { color:#e6f7fb; } </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background:#05445E">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('petugas.dashboard') }}">Petugas Panel</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Website</a></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-light" type="submit">Logout</button></form>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <aside class="col-12 col-md-3 col-lg-2 p-0 sidebar">
        <div class="p-3">
          <h5 class="mb-3">Petugas</h5>
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Transaksi</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Pengembalian</a></li>
          </ul>
        </div>
      </aside>
      <main class="col-12 col-md-9 col-lg-10 py-4">@yield('content')</main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
