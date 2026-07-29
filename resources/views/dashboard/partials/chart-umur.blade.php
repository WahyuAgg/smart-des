{{-- Distribusi Umur -- Horizontal Bar Chart --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
  <div class="flex items-center justify-between mb-4">
    <h3 class="text-sm font-semibold text-slate-700">Distribusi Umur</h3>
    <span class="text-xs font-medium text-slate-400" x-text="totalDistribusiUmur + ' jiwa'"></span>
  </div>

  <template x-if="dashboard?.distribusi_umur && Object.keys(dashboard.distribusi_umur).length > 0">
    <div class="space-y-1.5 max-h-85 overflow-y-auto pr-1">
      <template x-for="(item, index) in Object.values(dashboard.distribusi_umur)" :key="item.rentang_umur">
        <div class="flex items-center gap-2.5 group">
          <span class="w-10 text-[11px] font-medium text-slate-500 text-right shrink-0" x-text="item.rentang_umur"></span>
          <div class="flex-1 h-4 bg-slate-100 rounded-full overflow-hidden">
            <div class="h-full rounded-full transition-all duration-700 ease-out group-hover:brightness-110"
                 :style="`width: ${pct(item.jumlah, totalDistribusiUmur)}%; background-color: ${ageColor(index)}`">
            </div>
          </div>
          <span class="w-6 text-[11px] font-semibold text-slate-600 text-right shrink-0" x-text="item.jumlah"></span>
        </div>
      </template>
    </div>
  </template>

  <template x-if="!dashboard?.distribusi_umur || Object.keys(dashboard.distribusi_umur).length === 0">
    <p class="text-sm text-slate-400 text-center py-6">Belum ada data</p>
  </template>
</div>