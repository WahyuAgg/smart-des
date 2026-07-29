<!DOCTYPE html>
<html lang="id">
<head>
  @include('partials.head')
</head>
<body class="font-sans text-slate-800 antialiased">

  @include('partials.sidebar')

  <div x-data :class="$store.sidebar.open ? 'ml-64' : 'ml-0'" class="min-h-screen flex flex-col transition-all" style="transition-duration: 200ms;">
    @include('partials.navbar')

    <main class="flex-1 p-6">
      @yield('content')
    </main>

    @include('partials.footer')
  </div>

  @stack('scripts')
</body>
</html>
