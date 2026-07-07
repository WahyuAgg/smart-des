<!DOCTYPE html>
<html lang="id">
<head>
  @include('partials.head')
</head>
<body class="font-sans text-slate-800 antialiased">

  @include('partials.sidebar')

  <div class="ml-64 min-h-screen flex flex-col">
    @include('partials.navbar')

    <main class="flex-1 p-6">
      @yield('content')
    </main>

    @include('partials.footer')
  </div>

  @stack('scripts')
</body>
</html>
