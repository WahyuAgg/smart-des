<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Data RW</h4>
    <p class="text-xs text-slate-400">Pilih dusun dan masukkan nomor RW.</p>
  </div>

  <div class="space-y-2">
    <label class="block text-sm font-medium text-slate-700 mb-1">Dusun <span class="text-red-500">*</span></label>
    <select x-model="form.dusun_id" required
      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
      <option value="">- Pilih -</option>
      <template x-for="d in dusunList" :key="d.id">
        <option :value="d.id" x-text="d.nama"></option>
      </template>
    </select>
  </div>

  <x-form.input label="Nomor RW" model="form.nomor_rw" placeholder="Contoh: 001" required hint="Format 3 digit." />
  <x-form.input label="Ketua RW" model="form.ketua_rw" placeholder="Contoh: Pak RW" />
</section>