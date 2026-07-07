<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-10">
  <div>
    <h1 class="text-base font-semibold text-slate-800">@yield('page-title', 'Layanan Surat')</h1>
    @hasSection('page-subtitle')
      <p class="text-xs text-slate-500">@yield('page-subtitle')</p>
    @endif
  </div>

  <div class="flex items-center gap-3">
    <button class="relative w-9 h-9 rounded-full flex items-center justify-center hover:bg-slate-100 text-slate-500">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
      </svg>
    </button>
    <div class="w-9 h-9 rounded-full bg-accent-light text-accent-hover flex items-center justify-center font-semibold text-sm">
      {{ Str::of(auth()->user()->name ?? 'Petugas')->substr(0, 1) }}
    </div>
  </div>
</header>
