{{-- Distribusi Gender --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
  <div class="flex items-center gap-2 mb-4">
    <div class="w-8 h-8 rounded-lg bg-linear-to-br from-blue-400 to-pink-500 flex items-center justify-center shadow-sm">
      <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="5" r="3" /><path d="M3 21v-2a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v2" />
      </svg>
    </div>
    <h3 class="text-sm font-semibold text-slate-700">Distribusi Gender</h3>
  </div>

  <div class="space-y-3">
    {{-- Laki-laki --}}
    <div class="flex items-center gap-3">
      <span class="w-3 h-3 rounded-full shrink-0 shadow-sm bg-blue-500"></span>
      <span class="flex-1 text-sm text-slate-700 font-medium">Laki-laki</span>
      <div class="flex-1 h-4 bg-slate-100 rounded-full overflow-hidden max-w-28">
        <div class="h-full rounded-full transition-all duration-700 bg-blue-500"
             :style="`width: ${pct(dashboard?.jumlah_laki_laki ?? 0, dashboard?.total_penduduk ?? 1)}%`">
        </div>
      </div>
      <span class="text-sm font-semibold text-slate-600 w-8 text-right" x-text="dashboard?.jumlah_laki_laki ?? 0"></span>
    </div>

    {{-- Perempuan --}}
    <div class="flex items-center gap-3">
      <span class="w-3 h-3 rounded-full shrink-0 shadow-sm bg-pink-500"></span>
      <span class="flex-1 text-sm text-slate-700 font-medium">Perempuan</span>
      <div class="flex-1 h-4 bg-slate-100 rounded-full overflow-hidden max-w-28">
        <div class="h-full rounded-full transition-all duration-700 bg-pink-500"
             :style="`width: ${pct(dashboard?.jumlah_perempuan ?? 0, dashboard?.total_penduduk ?? 1)}%`">
        </div>
      </div>
      <span class="text-sm font-semibold text-slate-600 w-8 text-right" x-text="dashboard?.jumlah_perempuan ?? 0"></span>
    </div>

    {{-- Progress bar gabungan --}}
    <div class="mt-3 h-3 bg-slate-100 rounded-full overflow-hidden flex">
      <div class="h-full bg-blue-500 transition-all duration-700 rounded-l-full"
           :style="`width: ${pct(dashboard?.jumlah_laki_laki ?? 0, dashboard?.total_penduduk ?? 1)}%`"></div>
      <div class="h-full bg-pink-500 transition-all duration-700 rounded-r-full"
           :style="`width: ${pct(dashboard?.jumlah_perempuan ?? 0, dashboard?.total_penduduk ?? 1)}%`"></div>
    </div>
  </div>
</div>