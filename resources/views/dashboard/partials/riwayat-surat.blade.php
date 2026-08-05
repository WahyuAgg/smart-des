{{-- Riwayat Surat Terbaru --}}
<template x-if="isAuthenticated && riwayatSurat.length > 0">
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-2">
        <div
          class="w-8 h-8 rounded-lg bg-linear-to-br from-sky-400 to-sky-600 flex items-center justify-center shadow-sm">
          <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
            <polyline points="14 2 14 8 20 8" />
            <line x1="16" y1="13" x2="8" y2="13" />
            <line x1="16" y1="17" x2="8" y2="17" />
            <polyline points="10 9 9 9 8 9" />
          </svg>
        </div>
        <h3 class="text-sm font-semibold text-slate-700">Surat Terbaru</h3>
      </div>
      <a href="{{ Route::has('surat.riwayat') ? route('surat.riwayat') : '#' }}"
        class="text-xs font-medium text-sky-600 hover:text-sky-700 transition flex items-center gap-1">
        Lihat semua
        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="m9 18 6-6-6-6" />
        </svg>
      </a>
    </div>

    <div class="space-y-2 max-h-85 overflow-y-auto pr-1">
      <template x-for="(item, index) in riwayatSurat" :key="item.id || index">
        <div class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 transition group">
          {{-- Ikon status --}}
          <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0"
            :class="{
                'bg-yellow-50 text-yellow-600': item.status === 'diajukan',
                'bg-blue-50 text-blue-600': item.status === 'diproses',
                'bg-green-50 text-green-600': item.status === 'selesai',
                'bg-red-50 text-red-600': item.status === 'ditolak',
                'bg-slate-50 text-slate-400': !['diajukan', 'diproses', 'selesai', 'ditolak'].includes(item.status)
            }">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 6v6l4 2" x-show="item.status === 'diajukan'" />
              <path d="M12 8v4l3 3" x-show="item.status === 'diproses'" />
              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" x-show="item.status === 'selesai'" />
              <path d="M18 6L6 18M6 6l12 12" x-show="item.status === 'ditolak'" />
            </svg>
          </div>
          {{-- Info surat --}}
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-slate-700 truncate" x-text="item.jenis_surat_nama || '-'"></p>
            <p class="text-[11px] text-slate-400" x-text="$formatDate(item.tanggal_diajukan)"></p>
          </div>
          {{-- Badge status --}}
          <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full capitalize shrink-0"
            :class="badgeColor(item.status)" x-text="item.status || '-'"></span>
        </div>
      </template>
    </div>
  </div>
</template>
