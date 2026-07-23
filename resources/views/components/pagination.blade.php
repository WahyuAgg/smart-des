{{--
  Pagination generik untuk halaman master-data.

  Mengakses properti Alpine dari parent scope:
    meta.current_page  : halaman aktif
    meta.last_page     : halaman terakhir
    meta.total         : total data

  Memanggil metode Alpine:
    load(page)         : memuat halaman tertentu

  Contoh:
    @include('components.pagination')
--}}
<div x-show="meta.last_page > 1"
  class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between px-4 py-3 border-t border-slate-200 text-xs text-slate-500">
  <span>Halaman <span x-text="meta.current_page"></span> dari <span x-text="meta.last_page"></span> · <span x-text="meta.total"></span> data</span>
  <div class="flex gap-2">
    <button type="button" @click="load(meta.current_page - 1)" :disabled="meta.current_page <= 1"
      class="px-3 py-1.5 rounded-md border border-slate-300 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed">Sebelumnya</button>
    <button type="button" @click="load(meta.current_page + 1)" :disabled="meta.current_page >= meta.last_page"
      class="px-3 py-1.5 rounded-md border border-slate-300 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed">Berikutnya</button>
  </div>
</div>