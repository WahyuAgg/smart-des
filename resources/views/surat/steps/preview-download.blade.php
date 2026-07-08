<div x-show="step === 4" x-cloak class="text-center py-6">
  <div class="w-14 h-14 rounded-full bg-accent-light text-accent-hover flex items-center justify-center mx-auto mb-4">
    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
    </svg>
  </div>

  <h2 class="text-base font-semibold text-slate-800">Surat berhasil dibuat</h2>
  <p class="text-sm text-slate-500 mt-1 mb-6">
    Status: <span class="font-medium text-slate-700" x-text="result?.status"></span>
    <template x-if="result?.nomor_surat">
      <span> &middot; Nomor: <span x-text="result.nomor_surat"></span></span>
    </template>
  </p>

  <div class="border border-slate-200 rounded-lg overflow-hidden max-w-lg mx-auto text-left mb-6">
    <div class="px-4 py-2 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
      <p class="text-xs text-slate-400">Preview surat</p>
      <p class="text-xs text-slate-500 break-all text-right" x-text="result?.file_hasil"></p>
    </div>

    <iframe :src="result?.preview_url" class="w-full h-[420px] bg-slate-100" title="Preview surat"></iframe>

    <div class="px-4 py-2 bg-slate-50 border-t border-slate-200 text-center">
      <a :href="result?.preview_url" target="_blank" rel="noopener" class="text-xs text-accent hover:text-accent-hover font-medium">
        Preview tidak muncul? Buka di tab baru &rarr;
      </a>
    </div>
  </div>

  <div class="flex items-center justify-center gap-3">
    <a :href="result?.preview_url" download target="_blank" rel="noopener"
       class="inline-flex items-center gap-2 px-5 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 19h16" />
      </svg>
      Unduh Surat
    </a>
    <button type="button" @click="mulaiLagi()"
            class="px-5 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">
      Ajukan Surat Lain
    </button>
  </div>
</div>
