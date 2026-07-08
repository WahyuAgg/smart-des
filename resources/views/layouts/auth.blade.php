<!DOCTYPE html>
<html lang="id">
<head>
  @include('partials.head')
  <style>
    body {
      background: linear-gradient(135deg, #0B172A 0%, #12233F 50%, #183156 100%);
      min-height: 100vh;
    }
  </style>
</head>
<body class="font-sans antialiased">

  <div class="min-h-screen flex items-center justify-center p-4">
    @yield('content')
  </div>

  @stack('scripts')
</body>
</html>
