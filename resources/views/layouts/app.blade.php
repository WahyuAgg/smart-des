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

  {{-- Hydrate user store from localStorage on page load --}}
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.store('user', {
        get current() {
          return Auth.getUser();
        },
        get isLoggedIn() {
          return Auth.isLoggedIn();
        },
        get roles() {
          return this.current?.roles ?? [];
        },
        hasRole(role) {
          return this.roles.includes(role);
        },
        get isAdmin() {
          return Access.isAdmin(this.roles);
        },
        get isPetugas() {
          return this.hasRole('petugas');
        },
        get isKades() {
          return Access.isKades(this.roles);
        },
        /** Staff = admin atau petugas (bisa kelola data desa) */
        get isStaff() {
          return Access.isStaff(this.roles);
        },
      });
    });

    {{-- Client-side route guard — baca aturan dari Access config --}}
    (function() {
      // Tunggu sampai Vite module selesai load (yang mendefine window.Access & window.Auth)
      if (typeof Access === 'undefined' || typeof Auth === 'undefined') {
        document.addEventListener('DOMContentLoaded', function () {
          runRouteGuard();
        });
      } else {
        runRouteGuard();
      }

      function runRouteGuard() {
        if (typeof Access === 'undefined' || typeof Auth === 'undefined') return;
        const path = window.location.pathname;
        const level = Access.getRouteLevel(path);
        const user = Auth.getUser();
        const roles = user?.roles ?? [];

        if (!Access.canAccess(roles, level)) {
          if (level === 'public') return;
          if (level === 'auth' && !user) {
            window.location.href = '/login';
          } else {
            window.location.href = user ? '/' : '/login';
          }
        }
      }
    })();
  </script>
</body>
</html>
