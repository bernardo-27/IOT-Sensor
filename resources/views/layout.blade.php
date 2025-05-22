<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Plant Monitoring')</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Icons & Fonts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #fdf6f0;
    }
    .sidebar {
      min-height: 100vh;
      background: linear-gradient(180deg, #f6d365, #fda085);
    }
    .nav-link {
      color: white;
      font-weight: 500;
    }
    .nav-link:hover {
      color: #222;
    }
    .footer {
      background: #ffeedb;
      padding: 1rem;
      text-align: center;
      color: #666;
      margin-top: auto;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- Responsive Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-warning shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold text-white" href="#">🌿 Pechay Monitoring</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="{{ route('sensors.index') }}" class="nav-link">Sensors</a></li>
          <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-grow-1 container py-4">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; {{ date('Y') }} Pechay Monitoring Project. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')

</body>
</html>
