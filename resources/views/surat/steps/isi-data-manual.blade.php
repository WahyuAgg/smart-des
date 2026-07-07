<div x-show="step === 3" x-cloak>
  <h2 class="text-sm font-semibold text-slate-800 mb-1">Lengkapi data surat</h2>
  <p class="text-sm text-slate-500 mb-5">Periksa data otomatis dan lengkapi kolom yang masih kosong.</p>

  <div x-show="autoFields.length" class="mb-6">
    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Data otomatis</p>
    <div class="space-y-4">
      <template x-for="field in autoFields" :key="field.placeholder">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1" x-text="field.label"></label>
          <input :type="field.type === 'number' ? 'number' : 'text'"
                 x-model="dataSurat[field.placeholder]"
                 class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
        </div>
      </template>
    </div>
  </div>

  <div x-show="manualFields.length">
    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Perlu diisi</p>
    <div class="space-y-4">
      <template x-for="field in manualFields" :key="field.placeholder">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">
            <span x-text="field.label"></span>
            <span class="text-red-500">*</span>
          </label>

          <template x-if="field.type === 'textarea'">
            <textarea rows="3" x-model="dataSurat[field.placeholder]"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"></textarea>
          </template>
          <template x-if="field.type !== 'textarea'">
            <input :type="field.type === 'number' ? 'number' : (field.type === 'date' ? 'date' : 'text')"
                   x-model="dataSurat[field.placeholder]"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
          </template>
        </div>
      </template>
    </div>
  </div>

  <div class="flex justify-between mt-6">
    <button type="button" @click="kembali()"
            class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800">
      &larr; Kembali
    </button>
    <button type="button" @click="generateSurat()" :disabled="!canGenerate"
            class="px-5 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover disabled:opacity-40 disabled:cursor-not-allowed">
      Buat Surat
    </button>
  </div>
</div>
