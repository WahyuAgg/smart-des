{{-- Distribusi Agama --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
  <div class="flex items-center justify-between mb-4">
    <div class="flex items-center gap-2">
      <div class="w-8 h-8 rounded-lg bg-linear-to-br from-violet-400 to-violet-600 flex items-center justify-center shadow-sm">
        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
      </div>
      <h3 class="text-sm font-semibold text-slate-700">Distribusi Agama</h3>
    </div>
    <span class="text-xs font-medium text-slate-400" x-text="dashboard?.distribusi_agama?.length + ' agama'"></span>
  </div>

  <template x-if="dashboard?.distribusi_agama && dashboard.distribusi_agama.length > 0">
    <div class="space-y-3">
      <template x-for="(item, index) in dashboard.distribusi_agama" :key="item.agama">
        <div class="flex items-center gap-3 group">
          <span class="w-3 h-3 rounded-full shrink-0 shadow-sm" :style="`background-color: ${color(index)}`"></span>
          <span class="flex-1 text-sm text-slate-700 font-medium" x-text="item.agama"></span>
          <div class="flex-1 h-3 bg-slate-100 rounded-full overflow-hidden max-w-28">
            <div class="h-full rounded-full transition-all duration-700 ease-out group-hover:brightness-110"
                 :style="`width: ${pct(item.jumlah, dashboard.total_penduduk)}%; background-color: ${color(index)}`">
            </div>
          </div>
          <span class="text-sm font-semibold text-slate-600 w-8 text-right" x-text="item.jumlah"></span>
        </div>
      </template>
    </div>
  </template>

  <template x-if="!dashboard?.distribusi_agama || dashboard.distribusi_agama.length === 0">
    <p class="text-sm text-slate-400 text-center py-6">Belum ada data</p>
  </template>
</div>