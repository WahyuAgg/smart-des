<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Data RT</h4>
    <p class="text-xs text-slate-400">Pilih RW dan masukkan nomor RT.</p>
  </div>

  <div class="space-y-2">
    <label class="block text-sm font-medium text-slate-700 mb-1">RW <span class="text-red-500">*</span></label>
    <select x-model="form.rw_id" required
      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
      <option value="">- Pilih -</option>
      <template x-for="r in rwList" :key="r.id">
        <option :value="r.id" x-text="'RW ' + r.nomor_rw"></option>
      </template>
    </select>
  </div>

  <x-form.input label="Nomor RT" model="form.nomor_rt" placeholder="Contoh: 001" required hint="Format 3 digit." />
  <x-form.input label="Ketua RT" model="form.ketua_rt" placeholder="Contoh: Pak RT" />
</section>