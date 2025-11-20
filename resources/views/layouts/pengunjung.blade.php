<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Pengunjung - @yield('title', 'Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style> body { font-family: Poppins, system-ui, sans-serif; } .topbar { background:#0b5; } </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('pengunjung.dashboard') }}">Pengunjung</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Website</a></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-secondary" type="submit">Logout</button></form>
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
