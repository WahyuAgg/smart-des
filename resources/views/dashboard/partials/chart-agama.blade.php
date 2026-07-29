{{-- Distribusi Agama --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
  <h3 class="text-sm font-semibold text-slate-700 mb-4">Distribusi Agama</h3>

  <template x-if="dashboard?.distribusi_agama && dashboard.distribusi_agama.length > 0">
    <div class="space-y-3">
      <template x-for="(item, index) in dashboard.distribusi_agama" :key="item.agama">
        <div class="flex items-center gap-3">
          <span class="w-3 h-3 rounded-full shrink-0" :style="`background-color: ${color(index)}`"></span>
          <span class="flex-1 text-sm text-slate-700 truncate" x-text="item.agama"></span>
          <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden max-w-32">
            <div class="h-full rounded-full transition-all duration-700"
                 :style="`width: ${pct(item.jumlah, dashboard.total_penduduk)}%; background-color: ${color(index)}`">
            </div>
          </div>
          <span class="text-sm font-medium text-slate-600 w-10 text-right" x-text="item.jumlah"></span>
        </div>
      </template>
    </div>
  </template>

  <template x-if="!dashboard?.distribusi_agama || dashboard.distribusi_agama.length === 0">
    <p class="text-sm text-slate-400 text-center py-6">Belum ada data</p>
  </template>
</div>