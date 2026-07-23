@php
    $menu = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Pengajuan Surat', 'route' => 'surat.index', 'icon' => 'document'],
        ['label' => 'Riwayat Surat', 'route' => 'surat.riwayat', 'icon' => 'history'],
    ];

    // Master data: kelompok menu dengan submenu, tinggal tambah item baru di sini
    // setiap kali ada halaman master-data baru (jenis surat, penduduk, dst).
    $masterData = [
        ['label' => 'Field Surat', 'route' => 'master-data.master-field-surat.index'],
        ['label' => 'KK / Kartu Keluarga', 'route' => 'master-data.kk.index'],
        ['label' => 'Pendidikan', 'route' => 'master-data.pendidikan.index'],
        ['label' => 'Jenis Surat', 'route' => 'master-data.jenis-surat.index'],
        ['label' => 'Penduduk', 'route' => 'master-data.penduduk.index'],
    ];
    $masterDataActive = collect($masterData)->contains(fn($item) => request()->routeIs($item['route'] . '*'));

    $icons = [
        'home' => 'M3 11.5 12 4l9 7.5M5 10v9a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1v-9',
        'document' => 'M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm7 0v5h5M9 13h6M9 17h6M9 9h2',
        'history' => 'M4 4v5h5M4.6 12A8 8 0 1 0 6 6.3L4 9M12 8v4l3 2',
        'database' =>
            'M12 4c4.4 0 8 1.1 8 2.5S16.4 9 12 9s-8-1.1-8-2.5S7.6 4 12 4Zm-8 2.5V17c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5V6.5M4 11.75c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5',
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

        {{-- grup master data: bisa nambah halaman baru cukup edit array $masterData di atas --}}
        <div x-data="{ open: {{ $masterDataActive ? 'true' : 'false' }} }">
            <button type="button" @click="open = !open"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                     {{ $masterDataActive ? 'text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="{{ $icons['database'] }}" />
                </svg>
                <span class="flex-1 text-left">Master Data</span>
                <svg class="w-4 h-4 shrink-0 transition-transform" :class="open && 'rotate-180'" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                </svg>
            </button>

            <div x-show="open" x-collapse class="ml-11 mt-1 space-y-1 border-l border-white/10 pl-3">
                @foreach ($masterData as $item)
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
