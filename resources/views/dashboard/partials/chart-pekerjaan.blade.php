{{-- Distribusi Pekerjaan --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
  <div class="flex items-center justify-between mb-4">
    <h3 class="text-sm font-semibold text-slate-700">Distribusi Pekerjaan</h3>
    <span class="text-xs font-medium text-slate-400" x-text="dashboard?.distribusi_pekerjaan?.length + ' jenis'"></span>
  </div>

  <template x-if="dashboard?.distribusi_pekerjaan && dashboard.distribusi_pekerjaan.length > 0">
    <div class="space-y-2.5 max-h-85 overflow-y-auto pr-1">
      <template x-for="(item, index) in dashboard.distribusi_pekerjaan" :key="item.pekerjaan">
        <div class="flex items-center gap-3 group">
          <span class="w-3 h-3 rounded-full shrink-0 shadow-sm" :style="`background-color: ${color(index)}`"></span>
          <span class="flex-1 text-sm text-slate-700 truncate" x-text="item.pekerjaan || 'Tidak diketahui'"></span>
          <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden max-w-24">
            <div class="h-full rounded-full transition-all duration-700 ease-out group-hover:brightness-110"
                 :style="`width: ${pct(item.jumlah, dashboard.total_penduduk)}%; background-color: ${color(index)}`">
            </div>
          </div>
          <span class="text-sm font-semibold text-slate-600 w-8 text-right" x-text="item.jumlah"></span>
        </div>
      </template>
    </div>
  </template>

  <template x-if="!dashboard?.distribusi_pekerjaan || dashboard.distribusi_pekerjaan.length === 0">
    <p class="text-sm text-slate-400 text-center py-6">Belum ada data</p>
  </template>
</div>