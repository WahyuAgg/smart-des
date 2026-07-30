@php
  // ── Menu definitions with access level ──────────────────────
  // level: 'public' | 'auth' | 'staff' | 'admin'
  $menu = [
      ['label' => 'Dashboard',          'route' => 'dashboard',                         'icon' => 'home',     'level' => 'auth'],
      ['label' => 'Pengajuan Surat',    'route' => 'surat.index',                       'icon' => 'document', 'level' => 'public'],
      ['label' => 'Peta Desa',          'route' => 'peta-desa',                         'icon' => 'map',      'level' => 'public'],
      ['label' => 'Galeri Foto',        'route' => 'galeri',                            'icon' => 'camera',   'level' => 'public'],
      ['label' => 'Bacaan Edukatif',    'route' => 'bacaan.index',                      'icon' => 'book',     'level' => 'public'],
  ];

  // Master data desa
  $masterDataDesa = [
      ['label' => 'Profil Desa',        'route' => 'master-data.profil-desa.index'],
      ['label' => 'Dusun',              'route' => 'master-data.dusun.index'],
      ['label' => 'RW',                 'route' => 'master-data.rw.index'],
      ['label' => 'RT',                 'route' => 'master-data.rt.index'],
      ['label' => 'KK / Kartu Keluarga','route' => 'master-data.kk.index'],
      ['label' => 'Pendidikan',         'route' => 'master-data.pendidikan.index'],
      ['label' => 'Jabatan Perangkat',  'route' => 'master-data.jabatan-perangkat.index'],
      ['label' => 'Perangkat Desa',     'route' => 'master-data.perangkat-desa.index'],
      ['label' => 'Penduduk',           'route' => 'master-data.penduduk.index'],
  ];
  $masterDataDesaActive = collect($masterDataDesa)->contains(fn($item) => request()->routeIs($item['route'] . '*'));

  // Master data surat
  $masterDataSurat = [
      ['label' => 'Kategori Surat',     'route' => 'master-data.kategori-surat.index'],
      ['label' => 'Jenis Surat',        'route' => 'master-data.jenis-surat.index'],
      ['label' => 'Field Surat',        'route' => 'master-data.master-field-surat.index'],
      ['label' => 'Riwayat Surat',      'route' => 'surat.riwayat'],
  ];
  $masterDataSuratActive = collect($masterDataSurat)->contains(fn($item) => request()->routeIs($item['route'] . '*'));

  // Inventaris
  $inventaris = [
      ['label' => 'Kategori Barang',    'route' => 'inventaris.kategori-barang.index'],
      ['label' => 'Lokasi',             'route' => 'inventaris.lokasi.index'],
      ['label' => 'Daftar Barang',      'route' => 'inventaris.barang.index'],
      ['label' => 'Peminjaman',         'route' => 'inventaris.peminjaman.index'],
      ['label' => 'Mutasi / Buku Besar','route' => 'inventaris.mutasi.index'],
  ];
  $inventarisActive = collect($inventaris)->contains(fn($item) => request()->routeIs($item['route'] . '*'));

  // Manajemen Konten
  $manajemenKonten = [
      ['label' => 'Artikel',            'route' => 'manajemen-konten.artikel.index'],
      ['label' => 'Galeri',             'route' => 'manajemen-konten.galeri.index'],
  ];
  $manajemenKontenActive = collect($manajemenKonten)->contains(fn($item) => request()->routeIs($item['route'] . '*'));

  // Admin Sistem
  $adminSistem = [
      ['label' => 'User',               'route' => 'admin-sistem.user.index'],
      ['label' => 'Backup',             'route' => 'admin-sistem.backup.index'],
  ];
  $adminSistemActive = collect($adminSistem)->contains(fn($item) => request()->routeIs($item['route'] . '*'));

  $icons = [
      'home' => 'M3 11.5 12 4l9 7.5M5 10v9a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1v-9',
      'document' => 'M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm7 0v5h5M9 13h6M9 17h6M9 9h2',
      'history' => 'M4 4v5h5M4.6 12A8 8 0 1 0 6 6.3L4 9M12 8v4l3 2',
      'database' =>
          'M12 4c4.4 0 8 1.1 8 2.5S16.4 9 12 9s-8-1.1-8-2.5S7.6 4 12 4Zm-8 2.5V17c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5V6.5M4 11.75c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5',
      'box' =>
          'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16zM3.27 6.96 12 12.01l8.73-5.05M12 22.08V12',
      'map' => 'M9 20 4 17V5l5 3m0 0 5-3m-5 3v12m5-9 5-3v12l-5 3m0-12-5 3',
      'book' =>
          'M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5A2.5 2.5 0 0 1 4 19.5ZM12 7v8M8 7v2m8-2v2',
      'edit' => 'M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z',
      'camera' =>
          'M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2v11ZM9 13a3 3 0 1 0 6 0 3 3 0 0 0-6 0Z',
      'settings' =>
          'M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm0 0h0M8.3 21l-.9-1.6a10.5 10.5 0 0 1-1.3-.5l-1.7.5-1.4-2.4 1.3-1.2a9.5 9.5 0 0 1-.2-1.8 9.5 9.5 0 0 1 .2-1.8L3.4 11l1.4-2.4 1.7.5c.4-.2.8-.4 1.3-.5L8.3 7l1.4-2.4 1.7.5c.4-.3.8-.5 1.3-.6l.7-1.5h2.8l.7 1.5c.5.1.9.3 1.3.6l1.7-.5L20.6 7l-1.3 1.2c.3.6.5 1.1.6 1.8l1.7.5-1.4 2.4-1.7-.5c-.1.6-.3 1.2-.5 1.8l1.3 1.2-1.4 2.4-1.7-.5c-.4.2-.8.4-1.3.5l-.7 1.5H12l-.7-1.5a10.5 10.5 0 0 1-1.3-.5l-1.7.5L6.9 19l1.3-1.2a9.5 9.5 0 0 1-.2-1.8Z',
  ];
@endphp

<aside x-data x-show="$store.sidebar.open" x-cloak
  class="fixed inset-y-0 left-0 w-64 bg-navy-900 text-slate-200 flex flex-col z-30 transition-transform"
  :class="$store.sidebar.open ? 'translate-x-0' : '-translate-x-full'" style="transition-duration: 200ms;">
  <div class="h-16 flex items-center gap-2 px-5 border-b border-white/10">
    <div class="w-8 h-8 rounded-md bg-accent flex items-center justify-center">
      <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
        <text x="12" y="17",  font-size="18" font-weight="bold"
          text-anchor="middle" fill="currentColor">SD</text>
      </svg>
    </div>
    <span class="font-semibold text-white tracking-tight">SmartDes</span>
    <button type="button" @click="$store.sidebar.toggle()"
      class="ml-auto w-7 h-7 rounded-md flex items-center justify-center text-slate-400 hover:text-white hover:bg-navy-700 transition">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 6 6 18" />
        <path d="m6 6 12 12" />
      </svg>
    </button>
  </div>

  <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
    {{-- Top-level menu items (filtered by role via Access config) --}}
    @foreach ($menu as $item)
      @php
        $active = request()->routeIs($item['route'].'*');
        $showExpr = match ($item['level']) {
          'public' => 'true',
          'auth'   => 'Access.canAccess($store.user.roles, \'auth\')',
          'staff'  => 'Access.canAccess($store.user.roles, \'staff\')',
          'admin'  => 'Access.canAccess($store.user.roles, \'admin\')',
          default  => 'true',
        };
      @endphp
      <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
        x-show="{{ $showExpr }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                {{ $active ? 'bg-navy-700 text-white border-l-2 border-accent' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="{{ $icons[$item['icon']] }}" />
        </svg>
        {{ $item['label'] }}
      </a>
    @endforeach

    {{-- grup master data desa — staff only --}}
    <div x-show="Access.canAccess($store.user.roles, 'staff')" x-data="{ open: {{ $masterDataDesaActive ? 'true' : 'false' }} }">
      <button type="button" @click="open = !open"
        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                     {{ $masterDataDesaActive ? 'text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="{{ $icons['database'] }}" />
        </svg>
        <span class="flex-1 text-left">Master Data Desa</span>
        <svg class="w-4 h-4 shrink-0 transition-transform" :class="open && 'rotate-180'" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
        </svg>
      </button>

      <div x-show="open" x-collapse class="ml-11 mt-1 space-y-1 border-l border-white/10 pl-3">
        @foreach ($masterDataDesa as $item)
          @php $subActive = request()->routeIs($item['route'].'*'); @endphp
          <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
            class="block px-2 py-1.5 rounded-md text-sm transition
                    {{ $subActive ? 'text-accent font-medium' : 'text-slate-400 hover:text-white' }}">
            {{ $item['label'] }}
          </a>
        @endforeach
      </div>
    </div>

    {{-- grup master data surat — staff only --}}
    <div x-show="Access.canAccess($store.user.roles, 'staff')" x-data="{ open: {{ $masterDataSuratActive ? 'true' : 'false' }} }">
      <button type="button" @click="open = !open"
        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                     {{ $masterDataSuratActive ? 'text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="{{ $icons['document'] }}" />
        </svg>
        <span class="flex-1 text-left">Master Data Surat</span>
        <svg class="w-4 h-4 shrink-0 transition-transform" :class="open && 'rotate-180'" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
        </svg>
      </button>

      <div x-show="open" x-collapse class="ml-11 mt-1 space-y-1 border-l border-white/10 pl-3">
        @foreach ($masterDataSurat as $item)
          @php $subActive = request()->routeIs($item['route'].'*'); @endphp
          <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
            class="block px-2 py-1.5 rounded-md text-sm transition
                    {{ $subActive ? 'text-accent font-medium' : 'text-slate-400 hover:text-white' }}">
            {{ $item['label'] }}
          </a>
        @endforeach
      </div>
    </div>

    {{-- grup inventaris — staff only --}}
    <div x-show="Access.canAccess($store.user.roles, 'staff')" x-data="{ open: {{ $inventarisActive ? 'true' : 'false' }} }">
      <button type="button" @click="open = !open"
        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                     {{ $inventarisActive ? 'text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="{{ $icons['box'] }}" />
        </svg>
        <span class="flex-1 text-left">Inventaris Desa</span>
        <svg class="w-4 h-4 shrink-0 transition-transform" :class="open && 'rotate-180'" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
        </svg>
      </button>

      <div x-show="open" x-collapse class="ml-11 mt-1 space-y-1 border-l border-white/10 pl-3">
        @foreach ($inventaris as $item)
          @php $subActive = request()->routeIs($item['route'].'*'); @endphp
          <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
            class="block px-2 py-1.5 rounded-md text-sm transition
                    {{ $subActive ? 'text-accent font-medium' : 'text-slate-400 hover:text-white' }}">
            {{ $item['label'] }}
          </a>
        @endforeach
      </div>
    </div>

    {{-- grup manajemen konten — staff only --}}
    <div x-show="Access.canAccess($store.user.roles, 'staff')" x-data="{ open: {{ $manajemenKontenActive ? 'true' : 'false' }} }">
      <button type="button" @click="open = !open"
        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                     {{ $manajemenKontenActive ? 'text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="{{ $icons['edit'] }}" />
        </svg>
        <span class="flex-1 text-left">Manajemen Konten</span>
        <svg class="w-4 h-4 shrink-0 transition-transform" :class="open && 'rotate-180'" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
        </svg>
      </button>

      <div x-show="open" x-collapse class="ml-11 mt-1 space-y-1 border-l border-white/10 pl-3">
        @foreach ($manajemenKonten as $item)
          @php $subActive = request()->routeIs($item['route'].'*'); @endphp
          <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
            class="block px-2 py-1.5 rounded-md text-sm transition
                    {{ $subActive ? 'text-accent font-medium' : 'text-slate-400 hover:text-white' }}">
            {{ $item['label'] }}
          </a>
        @endforeach
      </div>
    </div>

    {{-- grup admin sistem — admin only --}}
    <div x-show="Access.canAccess($store.user.roles, 'admin')" x-data="{ open: {{ $adminSistemActive ? 'true' : 'false' }} }">
      <button type="button" @click="open = !open"
        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                     {{ $adminSistemActive ? 'text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="{{ $icons['settings'] }}" />
        </svg>
        <span class="flex-1 text-left">Admin Sistem</span>
        <svg class="w-4 h-4 shrink-0 transition-transform" :class="open && 'rotate-180'" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
        </svg>
      </button>

      <div x-show="open" x-collapse class="ml-11 mt-1 space-y-1 border-l border-white/10 pl-3">
        @foreach ($adminSistem as $item)
          @php $subActive = request()->routeIs($item['route'].'*'); @endphp
          <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
            class="block px-2 py-1.5 rounded-md text-sm transition
                    {{ $subActive ? 'text-accent font-medium' : 'text-slate-400 hover:text-white' }}">
            {{ $item['label'] }}
          </a>
        @endforeach
      </div>
    </div>
  </nav>

  {{-- User info footer — only show when logged in --}}
  <div x-show="$store.user.isLoggedIn"
       class="px-3 py-4 border-t border-white/10 text-xs text-slate-400">
    Masuk sebagai
    <span class="text-slate-200 font-medium" x-text="$store.user.current?.name || 'Petugas'"></span>
    <span x-show="Access.isAdmin($store.user.roles)" class="ml-1.5 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-accent/20 text-accent">Admin</span>
    <span x-show="$store.user.hasRole('petugas')" class="ml-1.5 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-blue-400/20 text-blue-300">Petugas</span>
    <span x-show="Access.isKades($store.user.roles)" class="ml-1.5 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-green-400/20 text-green-300">Kepala Desa</span>
  </div>
</aside>

{{-- Backdrop untuk mobile --}}
<div x-data x-show="$store.sidebar.open" x-cloak @click="$store.sidebar.close()"
  class="fixed inset-0 z-20 bg-black/50 lg:hidden"></div>
