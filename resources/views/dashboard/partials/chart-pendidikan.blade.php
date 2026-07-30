{{-- Distribusi Pendidikan --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
  <div class="flex items-center justify-between mb-4">
    <h3 class="text-sm font-semibold text-slate-700">Distribusi Pendidikan</h3>
    <span class="text-xs font-medium text-slate-400" x-text="dashboard?.distribusi_pendidikan?.length + ' kategori'"></span>
  </div>

  <template x-if="dashboard?.distribusi_pendidikan && dashboard.distribusi_pendidikan.length > 0">
    <div class="space-y-2.5 max-h-85 overflow-y-auto pr-1">
      <template x-for="(item, index) in dashboard.distribusi_pendidikan" :key="item.tingkat_pendidikan">
        <div class="flex items-center gap-3 group">
          <span class="w-3 h-3 rounded-full shrink-0 shadow-sm" :style="`background-color: ${color(index)}`"></span>
          <span class="flex-1 text-sm text-slate-700 truncate" x-text="item.tingkat_pendidikan"></span>
          <div class="w-28 sm:w-36 h-2.5 bg-slate-100 rounded-full overflow-hidden shrink-0">
            <div class="h-full rounded-full transition-all duration-700 ease-out group-hover:brightness-110"
                 :style="`width: ${barPct(item.jumlah, maxVal(dashboard.distribusi_pendidikan))}%; background-color: ${color(index)}`">
            </div>
          </div>
          <span class="text-sm font-semibold text-slate-600 w-8 text-right" x-text="item.jumlah"></span>
        </div>
      </template>
    </div>
  </template>

  <template x-if="!dashboard?.distribusi_pendidikan || dashboard.distribusi_pendidikan.length === 0">
    <p class="text-sm text-slate-400 text-center py-6">Belum ada data</p>
  </template>
</div>