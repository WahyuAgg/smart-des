{{-- Full-width background for stats + visi --}}
<div class="bg-slate-50 border-b border-slate-200">
  <div class="px-6 py-6 space-y-6">
    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

      {{-- Total Penduduk --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4 hover:shadow-md hover:border-emerald-200 transition-all group">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0 shadow-sm group-hover:scale-110 transition-transform">
          <svg class="w-6 h-6 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M23 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" />
          </svg>
        </div>
        <div>
          <p class="text-2xl font-bold text-slate-800" x-text="dashboard?.total_penduduk ?? 0"></p>
          <p class="text-xs text-slate-500">Total Penduduk Terdata</p>
        </div>
      </div>

      {{-- Laki-laki --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4 hover:shadow-md hover:border-blue-200 transition-all group">
        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0 shadow-sm group-hover:scale-110 transition-transform">
          <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="10" cy="5" r="3" /><path d="M3 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2" /><path d="M19 3v6" /><path d="M16 6h6" />
          </svg>
        </div>
        <div>
          <p class="text-2xl font-bold text-slate-800" x-text="dashboard?.jumlah_laki_laki ?? 0"></p>
          <p class="text-xs text-slate-500">Laki-laki</p>
        </div>
      </div>

      {{-- Perempuan --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4 hover:shadow-md hover:border-pink-200 transition-all group">
        <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center shrink-0 shadow-sm group-hover:scale-110 transition-transform">
          <svg class="w-6 h-6 text-pink-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="12" cy="5" r="3" /><path d="M3 21v-2a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v2" /><path d="M12 12v6" /><path d="M9 15h6" />
          </svg>
        </div>
        <div>
          <p class="text-2xl font-bold text-slate-800" x-text="dashboard?.jumlah_perempuan ?? 0"></p>
          <p class="text-xs text-slate-500">Perempuan</p>
        </div>
      </div>

      {{-- Jumlah KK --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center gap-4 hover:shadow-md hover:border-amber-200 transition-all group">
        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center shrink-0 shadow-sm group-hover:scale-110 transition-transform">
          <svg class="w-6 h-6 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <rect x="2" y="3" width="20" height="14" rx="2" /><path d="M8 21h8" /><path d="M12 17v4" />
          </svg>
        </div>
        <div>
          <p class="text-2xl font-bold text-slate-800" x-text="dashboard?.jumlah_kk ?? 0"></p>
          <p class="text-xs text-slate-500">Kartu Keluarga Terdata</p>
        </div>
      </div>

    </div>

  </div>
</div>