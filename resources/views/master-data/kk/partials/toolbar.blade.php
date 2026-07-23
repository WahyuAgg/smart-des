<div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
  <div>
    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-accent">Master Data</p>
    <h1 class="text-2xl font-semibold text-slate-900 mt-1">Kartu Keluarga</h1>
    <p class="text-sm text-slate-500 mt-1">Tambah, ubah, cari, dan hapus data KK dari satu halaman.</p>
  </div>

  <div class="flex flex-col sm:flex-row gap-3 sm:items-center w-full lg:w-auto">
    <div class="relative w-full sm:w-80">
      <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="m21 21-4.3-4.3M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
      </svg>
      <input type="text" x-model="search" @input.debounce.400ms="load(1)" placeholder="Cari nomor KK atau NIK kepala keluarga..."
        class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
    </div>

    <button type="button" @click="openCreate()"
      class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover shrink-0">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
      </svg>
      Tambah KK
    </button>
  </div>
</div>