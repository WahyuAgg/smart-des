{{-- Peminjaman Inventaris Terbaru --}}
<template x-if="isAuthenticated && dashboard?.peminjaman_inventaris?.length > 0">
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-2">
        <div
          class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center shadow-sm">
          <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="7" width="20" height="14" rx="2" />
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
          </svg>
        </div>
        <h3 class="text-sm font-semibold text-slate-700">Peminjaman Terbaru</h3>
      </div>
      <a href="{{ Route::has('inventaris.peminjaman.index') ? route('inventaris.peminjaman.index') : '#' }}"
        class="text-xs font-medium text-orange-600 hover:text-orange-700 transition flex items-center gap-1">
        Lihat semua
        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="m9 18 6-6-6-6" />
        </svg>
      </a>
    </div>

    <div class="space-y-2 max-h-85 overflow-y-auto pr-1">
      <template x-for="(item, index) in dashboard.peminjaman_inventaris" :key="item.id || index">
        <div class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 transition group">
          {{-- Status Icon --}}
          <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0"
            :class="{
                'bg-yellow-50 text-yellow-600': item.status === 'dipinjam',
                'bg-green-50 text-green-600': item.status === 'dikembalikan',
                'bg-slate-50 text-slate-400': !['dipinjam', 'dikembalikan'].includes(item.status)
            }">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 6v6l4 2" x-show="item.status === 'dipinjam'" />
              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" x-show="item.status === 'dikembalikan'" />
            </svg>
          </div>

          {{-- Info Peminjaman --}}
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-slate-700 truncate" x-text="item.nama_peminjam || '-'"></p>
            <p class="text-[11px] text-slate-400 truncate">
              <span x-text="item.nomor || '-'"></span>
              <span class="mx-1">•</span>
              <span x-text="item.details?.length || 0"></span> barang
            </p>
          </div>

          {{-- Status Badge --}}
          <span class="text-[10px] font-semibold px-2 py-1 rounded-full shrink-0"
            :class="{
                'bg-yellow-100 text-yellow-700': item.status === 'dipinjam',
                'bg-green-100 text-green-700': item.status === 'dikembalikan',
                'bg-slate-100 text-slate-600': !['dipinjam', 'dikembalikan'].includes(item.status)
            }"
            x-text="item.status === 'dipinjam' ? 'Dipinjam' : (item.status === 'dikembalikan' ? 'Dikembalikan' : item.status)">
          </span>
        </div>
      </template>
    </div>
  </div>
</template>
