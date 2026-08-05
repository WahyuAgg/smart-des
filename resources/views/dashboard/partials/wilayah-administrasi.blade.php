{{-- Wilayah Administrasi --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
  <div class="flex items-center justify-between mb-4">
    <div class="flex items-center gap-2">
      <div
        class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center shadow-sm">
        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
          <circle cx="12" cy="10" r="3" />
        </svg>
      </div>
      <h3 class="text-sm font-semibold text-slate-700">Wilayah Administrasi</h3>
    </div>
  </div>

  <div class="space-y-3">
    {{-- Dusun --}}
    <div
      class="flex items-center justify-between p-3 rounded-lg bg-gradient-to-r from-indigo-50 to-transparent hover:from-indigo-100 transition">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
          <svg class="w-5 h-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
          </svg>
        </div>
        <span class="text-sm font-medium text-slate-700">Dusun</span>
      </div>
      <span class="text-lg font-bold text-indigo-600"
        x-text="dashboard?.wilayah_administrasi?.jumlah_dusun ?? 0"></span>
    </div>

    {{-- RW --}}
    <div
      class="flex items-center justify-between p-3 rounded-lg bg-gradient-to-r from-blue-50 to-transparent hover:from-blue-100 transition">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
          <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" />
            <rect x="14" y="3" width="7" height="7" />
            <rect x="14" y="14" width="7" height="7" />
            <rect x="3" y="14" width="7" height="7" />
          </svg>
        </div>
        <span class="text-sm font-medium text-slate-700">RW</span>
      </div>
      <span class="text-lg font-bold text-blue-600" x-text="dashboard?.wilayah_administrasi?.jumlah_rw ?? 0"></span>
    </div>

    {{-- RT --}}
    <div
      class="flex items-center justify-between p-3 rounded-lg bg-gradient-to-r from-cyan-50 to-transparent hover:from-cyan-100 transition">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-cyan-100 flex items-center justify-center">
          <svg class="w-5 h-5 text-cyan-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
          </svg>
        </div>
        <span class="text-sm font-medium text-slate-700">RT</span>
      </div>
      <span class="text-lg font-bold text-cyan-600" x-text="dashboard?.wilayah_administrasi?.jumlah_rt ?? 0"></span>
    </div>
  </div>
</div>
