<header x-data="{
  user: Auth.getUser(),
  loggingOut: false,
  async doLogout() {
    this.loggingOut = true;
    await Auth.logout(window.API_BASE_URL);
  }
}" class="h-16 bg-slate-200 border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-10">
  <div class="flex items-center gap-3">
    {{-- Toggle sidebar --}}
    <button type="button" @click="$store.sidebar.toggle()"
      class="w-9 h-9 rounded-lg flex items-center justify-center hover:bg-slate-100 text-slate-500 transition">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 12h18M3 6h18M3 18h18" />
      </svg>
    </button>
    <div>
      <h1 class="text-base font-semibold text-slate-800">@yield('page-title', 'Layanan Surat')</h1>
      @hasSection('page-subtitle')
        <p class="text-xs text-slate-500">@yield('page-subtitle')</p>
      @endif
    </div>
  </div>

  <div class="flex items-center gap-3">
    <button class="relative w-9 h-9 rounded-full flex items-center justify-center hover:bg-slate-100 text-slate-500">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
      </svg>
    </button>

    {{-- User avatar --}}
    <div class="w-9 h-9 rounded-full bg-accent-light text-accent-hover flex items-center justify-center">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
        <circle cx="12" cy="7" r="4" />
      </svg>
    </div>

    {{-- Logout button --}}
    <button @click="doLogout()"
            :disabled="loggingOut"
            class="w-9 h-9 rounded-full flex items-center justify-center hover:bg-red-50 text-slate-400 hover:text-red-500 transition disabled:opacity-50"
            title="Logout">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
        <polyline points="16 17 21 12 16 7" />
        <line x1="21" y1="12" x2="9" y2="12" />
      </svg>
    </button>
  </div>
</header>
