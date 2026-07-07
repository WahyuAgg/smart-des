@php
  $menu = [
    ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home'],
    ['label' => 'Pengajuan Surat', 'route' => 'surat.index', 'icon' => 'document'],
    ['label' => 'Riwayat Surat', 'route' => 'surat.riwayat', 'icon' => 'history'],
    ['label' => 'Data Penduduk', 'route' => 'penduduk.index', 'icon' => 'users'],
  ];

  $icons = [
    'home' => 'M3 11.5 12 4l9 7.5M5 10v9a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1v-9',
    'document' => 'M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm7 0v5h5M9 13h6M9 17h6M9 9h2',
    'history' => 'M4 4v5h5M4.6 12A8 8 0 1 0 6 6.3L4 9M12 8v4l3 2',
    'users' => 'M16 14a4 4 0 1 0-8 0M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 8v-1a4 4 0 0 0-3-3.9M2 20v-1a5 5 0 0 1 5-5h2a5 5 0 0 1 5 5v1',
  ];
@endphp

<aside class="fixed inset-y-0 left-0 w-64 bg-navy-900 text-slate-200 flex flex-col">
  <div class="h-16 flex items-center gap-2 px-5 border-b border-white/10">
    <div class="w-8 h-8 rounded-md bg-accent flex items-center justify-center font-bold text-white">S</div>
    <span class="font-semibold text-white tracking-tight">SIAK Desa</span>
  </div>

  <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
    @foreach ($menu as $item)
      @php $active = request()->routeIs($item['route'].'*'); @endphp
      <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                {{ $active ? 'bg-navy-700 text-white border-l-2 border-accent' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="{{ $icons[$item['icon']] }}" />
        </svg>
        {{ $item['label'] }}
      </a>
    @endforeach
  </nav>

  <div class="px-3 py-4 border-t border-white/10 text-xs text-slate-400">
    Masuk sebagai <span class="text-slate-200 font-medium">{{ auth()->user()->name ?? 'Petugas' }}</span>
  </div>
</aside>
