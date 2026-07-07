<div x-show="step === 2" x-cloak>
  <h2 class="text-sm font-semibold text-slate-800 mb-1">Isi data NIK</h2>
  <p class="text-sm text-slate-500 mb-5">
    Surat <span class="font-medium text-slate-700" x-text="selectedJenisSurat?.nama_jenis_surat"></span>
    membutuhkan NIK untuk peran berikut.
  </p>

  <div class="space-y-4">
    <template x-for="role in rolesUrut" :key="role.id">
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">
          <span x-text="role.label"></span>
          <span x-show="role.wajib" class="text-red-500">*</span>
        </label>
        <input type="text" inputmode="numeric" maxlength="16" placeholder="16 digit NIK"
               x-model="nikByRole[role.kode]"
               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
        <p x-show="role.deskripsi" x-text="role.deskripsi" class="text-xs text-slate-400 mt-1"></p>
      </div>
    </template>

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Keperluan (opsional)</label>
      <input type="text" x-model="keperluan" placeholder="Contoh: pengajuan BPJS"
             class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
    </div>
  </div>

  <div class="flex justify-between mt-6">
    <button type="button" @click="kembali()"
            class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800">
      &larr; Kembali
    </button>
    <button type="button" @click="submitNik()" :disabled="!canSubmitNik"
            class="px-5 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover disabled:opacity-40 disabled:cursor-not-allowed">
      Lanjutkan
    </button>
  </div>
</div>
