@php
    $menu = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Pengajuan Surat', 'route' => 'surat.index', 'icon' => 'document'],
    ];

    // Master data desa: kelompok menu dengan submenu
    $masterDataDesa = [
        ['label' => 'KK / Kartu Keluarga', 'route' => 'master-data.kk.index'],
        ['label' => 'Pendidikan', 'route' => 'master-data.pendidikan.index'],
        ['label' => 'Jabatan Perangkat', 'route' => 'master-data.jabatan-perangkat.index'],
        ['label' => 'Perangkat Desa', 'route' => 'master-data.perangkat-desa.index'],
        ['label' => 'Penduduk', 'route' => 'master-data.penduduk.index'],
    ];
    $masterDataDesaActive = collect($masterDataDesa)->contains(fn($item) => request()->routeIs($item['route'] . '*'));

    // Master data surat: kelompok menu surat-menyurat
    $masterDataSurat = [
        ['label' => 'Jenis Surat', 'route' => 'master-data.jenis-surat.index'],
        ['label' => 'Field Surat', 'route' => 'master-data.master-field-surat.index'],
        ['label' => 'Riwayat Surat', 'route' => 'surat.riwayat'],
    ];
    $masterDataSuratActive = collect($masterDataSurat)->contains(fn($item) => request()->routeIs($item['route'] . '*'));

    // Inventaris: kelompok menu baru
    $inventaris = [
        ['label' => 'Kategori Barang', 'route' => 'inventaris.kategori-barang.index'],
        ['label' => 'Lokasi', 'route' => 'inventaris.lokasi.index'],
        ['label' => 'Daftar Barang', 'route' => 'inventaris.barang.index'],
        ['label' => 'Peminjaman', 'route' => 'inventaris.peminjaman.index'],
        ['label' => 'Mutasi / Buku Besar', 'route' => 'inventaris.mutasi.index'],
    ];
    $inventarisActive = collect($inventaris)->contains(fn($item) => request()->routeIs($item['route'] . '*'));

    $icons = [
        'home' => 'M3 11.5 12 4l9 7.5M5 10v9a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1v-9',
        'document' => 'M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm7 0v5h5M9 13h6M9 17h6M9 9h2',
        'history' => 'M4 4v5h5M4.6 12A8 8 0 1 0 6 6.3L4 9M12 8v4l3 2',
        'database' =>
            'M12 4c4.4 0 8 1.1 8 2.5S16.4 9 12 9s-8-1.1-8-2.5S7.6 4 12 4Zm-8 2.5V17c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5V6.5M4 11.75c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5',
        'box' => 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16zM3.27 6.96 12 12.01l8.73-5.05M12 22.08V12',
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
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="{{ $icons[$item['icon']] }}" />
                </svg>
                {{ $item['label'] }}
            </a>
        @endforeach

        {{-- grup master data desa --}}
        <div x-data="{ open: {{ $masterDataDesaActive ? 'true' : 'false' }} }">
            <button type="button" @click="open = !open"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                     {{ $masterDataDesaActive ? 'text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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

        {{-- grup master data surat --}}
        <div x-data="{ open: {{ $masterDataSuratActive ? 'true' : 'false' }} }">
            <button type="button" @click="open = !open"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                     {{ $masterDataSuratActive ? 'text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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

        {{-- grup inventaris: baru --}}
        <div x-data="{ open: {{ $inventarisActive ? 'true' : 'false' }} }">
            <button type="button" @click="open = !open"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                     {{ $inventarisActive ? 'text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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
    </nav>

    <div x-data="{ user: Auth.getUser() }" class="px-3 py-4 border-t border-white/10 text-xs text-slate-400">
        Masuk sebagai <span class="text-slate-200 font-medium" x-text="user?.name || 'Petugas'"></span>
    </div>
</aside>
