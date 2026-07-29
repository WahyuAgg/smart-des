{{-- Perangkat Desa --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
  <div class="flex items-center justify-between mb-4">
    <div class="flex items-center gap-2">
      <div class="w-8 h-8 rounded-lg bg-linear-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-sm">
        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
      </div>
      <h3 class="text-sm font-semibold text-slate-700">Perangkat Desa</h3>
    </div>
    <span class="text-xs font-medium text-slate-400" x-text="perangkatDesa.length + ' orang'"></span>
  </div>

  <template x-if="perangkatDesa.length > 0">
    <div class="space-y-2 max-h-85 overflow-y-auto pr-1">
      <template x-for="(item, index) in perangkatDesa" :key="item.kode || index">
        <div class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 transition group">
          {{-- Avatar --}}
          <div class="w-9 h-9 rounded-full shrink-0 flex items-center justify-center text-white text-xs font-bold shadow-sm bg-linear-to-br"
               :class="[
                 'from-purple-400 to-purple-600',
                 'from-blue-400 to-blue-600',
                 'from-emerald-400 to-emerald-600',
                 'from-amber-400 to-orange-500',
                 'from-rose-400 to-rose-500',
                 'from-cyan-400 to-cyan-600',
                 'from-indigo-400 to-indigo-600',
                 'from-teal-400 to-teal-600',
               ][index % 8]">
            <span x-text="(item.perangkat?.nama || '?').charAt(0).toUpperCase()"></span>
          </div>
          {{-- Info --}}
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-slate-700 truncate" x-text="item.perangkat?.nama || '-'"></p>
            <p class="text-[11px] text-slate-400 truncate" x-text="item.nama || '-'"></p>
          </div>
          {{-- Badge --}}
          <template x-if="item.urutan <= 2">
            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full"
                  :class="item.urutan === 1 ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700'"
                  x-text="item.urutan === 1 ? 'KADES' : 'SEKDES'"></span>
          </template>
        </div>
      </template>
    </div>
  </template>

  <template x-if="perangkatDesa.length === 0">
    <p class="text-sm text-slate-400 text-center py-6">Belum ada data perangkat desa</p>
  </template>
</div>