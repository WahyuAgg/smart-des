<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Lookup Referensi</h4>
    <p class="text-xs text-slate-400">Pilih KK dan pendidikan dengan pencarian langsung.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="relative" @click.away="kkOpen = false">
      <label class="block text-sm font-medium text-slate-700 mb-1">ID KK</label>
      <input type="hidden" x-model="form.kk_id">
      <input
        type="text"
        x-model="kkSearch"
        @focus="kkOpen = true"
        @input.debounce.300ms="searchKk()"
        placeholder="Cari no_kk"
        autocomplete="off"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
      >

      <div x-show="kkOpen" x-transition class="absolute z-30 mt-1 w-full rounded-lg border border-slate-200 bg-white shadow-lg overflow-hidden">
        <template x-if="kkLoading">
          <div class="px-3 py-2 text-sm text-slate-400">Memuat data KK...</div>
        </template>

        <template x-if="!kkLoading && visibleKkOptions().length === 0">
          <div class="px-3 py-2 text-sm text-slate-400">Tidak ada KK yang cocok.</div>
        </template>

        <template x-for="option in visibleKkOptions()" :key="option.id">
          <button type="button" @click="selectKk(option)" class="w-full px-3 py-2 text-left hover:bg-slate-50 border-t border-slate-100 first:border-t-0">
            <div class="text-sm font-medium text-slate-800" x-text="option.no_kk"></div>
            <div class="text-xs text-slate-400" x-text="'ID: ' + option.id"></div>
          </button>
        </template>
      </div>
    </div>

    <div class="relative" @click.away="pendidikanOpen = false">
      <label class="block text-sm font-medium text-slate-700 mb-1">ID Pendidikan</label>
      <input type="hidden" x-model="form.pendidikan_id">
      <input
        type="text"
        x-model="pendidikanSearch"
        @focus="searchPendidikan()"
        @input.debounce.300ms="searchPendidikan()"
        placeholder="Cari tingkat pendidikan"
        autocomplete="off"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
      >

      <div x-show="pendidikanOpen" x-transition class="absolute z-30 mt-1 w-full rounded-lg border border-slate-200 bg-white shadow-lg overflow-hidden">
        <template x-if="pendidikanLoading">
          <div class="px-3 py-2 text-sm text-slate-400">Memuat data pendidikan...</div>
        </template>

        <template x-if="!pendidikanLoading && visiblePendidikanOptions().length === 0">
          <div class="px-3 py-2 text-sm text-slate-400">Tidak ada pendidikan yang cocok.</div>
        </template>

        <template x-for="option in visiblePendidikanOptions()" :key="option.id">
          <button type="button" @click="selectPendidikan(option)" class="w-full px-3 py-2 text-left hover:bg-slate-50 border-t border-slate-100 first:border-t-0">
            <div class="text-sm font-medium text-slate-800" x-text="option.tingkat_pendidikan"></div>
            <div class="text-xs text-slate-400" x-text="'ID: ' + option.id"></div>
          </button>
        </template>
      </div>
    </div>
  </div>
</section>