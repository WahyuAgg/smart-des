{{-- Distribusi Umur -- Horizontal Bar Chart --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
  <h3 class="text-sm font-semibold text-slate-700 mb-4">Distribusi Umur</h3>

  <template x-if="dashboard?.distribusi_umur && Object.keys(dashboard.distribusi_umur).length > 0">
    <div class="space-y-2">
      <template x-for="(item, index) in Object.values(dashboard.distribusi_umur)" :key="item.rentang_umur">
        <div class="flex items-center gap-3">
          <span class="w-10 text-xs font-medium text-slate-600 text-right shrink-0" x-text="item.rentang_umur"></span>
          <div class="flex-1 h-5 bg-slate-100 rounded-full overflow-hidden">
            <div class="h-full rounded-full transition-all duration-700"
                 :style="`width: ${pct(item.jumlah, totalDistribusiUmur)}%; background-color: ${ageColor(index)}`">
            </div>
          </div>
          <span class="w-8 text-xs font-medium text-slate-500 text-right shrink-0" x-text="item.jumlah"></span>
        </div>
      </template>
    </div>
  </template>

  <template x-if="!dashboard?.distribusi_umur || Object.keys(dashboard.distribusi_umur).length === 0">
    <p class="text-sm text-slate-400 text-center py-6">Belum ada data</p>
  </template>
</div>