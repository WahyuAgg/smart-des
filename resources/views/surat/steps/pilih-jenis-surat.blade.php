<div x-show="step === 1" x-cloak>
  <h2 class="text-sm font-semibold text-slate-800 mb-1">Pilih jenis surat</h2>
  <p class="text-sm text-slate-500 mb-5">Pilih layanan surat keterangan yang ingin diajukan.</p>

  <div x-show="!loading && jenisSuratList.length === 0" class="text-sm text-slate-400 py-8 text-center">
    Belum ada jenis surat yang tersedia.
  </div>

  <div class="grid sm:grid-cols-2 gap-3">
    <template x-for="item in jenisSuratList" :key="item.id">
      <button type="button" @click="pilihJenisSurat(item)"
              class="text-left border border-slate-200 rounded-lg p-4 hover:border-accent hover:bg-accent-light/40 transition group">
        <div class="flex items-start justify-between gap-2">
          <div>
            <p class="text-sm font-semibold text-slate-800 group-hover:text-accent-hover" x-text="item.nama_jenis_surat"></p>
            <p class="text-xs text-slate-500 mt-1" x-text="item.kode_jenis_surat"></p>
          </div>
          <svg class="w-4 h-4 text-slate-300 group-hover:text-accent shrink-0 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </div>
        <p x-show="item.deskripsi" x-text="item.deskripsi" class="text-xs text-slate-500 mt-2"></p>
      </button>
    </template>
  </div>
</div>
