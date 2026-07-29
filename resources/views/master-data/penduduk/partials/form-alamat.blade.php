<section class="space-y-4">
  <div class="flex items-center justify-between gap-3">
    <div>
      <h4 class="text-sm font-semibold text-slate-800">Alamat</h4>
      <p class="text-xs text-slate-400">Lengkapi jika data alamat akan disimpan sekaligus.</p>
    </div>

    <label class="inline-flex items-center gap-2 text-sm text-slate-600 shrink-0">
      <input type="checkbox" x-model="form.alamat.is_utama" class="rounded border-slate-300 text-accent focus:ring-accent">
      Alamat utama
    </label>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="Label Alamat" model="form.alamat.label_alamat" placeholder="Rumah / Kantor" />
    <x-form.input label="Negara" model="form.alamat.negara" placeholder="Indonesia" />
    <x-form.textarea class="md:col-span-2" label="Alamat Lengkap" model="form.alamat.alamat_lengkap" rows="3"
      placeholder="Alamat lengkap sesuai kebutuhan surat" />
    <x-form.input label="Jalan" model="form.alamat.jalan" placeholder="Nama jalan" />
    <x-form.input label="Gedung / Perumahan" model="form.alamat.gedung_perumahan" placeholder="Nama komplek" />
    <div class="grid grid-cols-3 gap-4 md:col-span-2 lg:col-span-1">
      <x-form.input label="No. Rumah" model="form.alamat.nomor_rumah" placeholder="12" />
      <x-form.input label="Blok" model="form.alamat.blok" placeholder="A" />
      <x-form.input label="Lantai" model="form.alamat.no_lantai" placeholder="1" />
    </div>
    <div class="grid grid-cols-2 gap-4 md:col-span-2 lg:col-span-1">
      <x-form.input label="Unit" model="form.alamat.no_unit" placeholder="3" />
      <x-form.input label="Kode Pos" model="form.alamat.kode_pos" placeholder="54172" />
    </div>
    <div class="grid grid-cols-2 gap-4 md:col-span-2 lg:col-span-1">
      <x-form.input label="RT" model="form.alamat.rt" placeholder="001" />
      <x-form.input label="RW" model="form.alamat.rw" placeholder="001" />
    </div>
    <x-form.input label="Dusun" model="form.alamat.dusun" placeholder="Nama dusun" />

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Provinsi</label>
      <select x-model="provinsiCode" @change="onProvinsiChange()"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        {{-- HACK: Fallback placeholder — jika code tidak ketemu (label mismatch), tampilkan nilai lama dari form --}}
        <option value="" x-text="provinsiCode ? 'Pilih provinsi' : (form.alamat.provinsi || 'Pilih provinsi')" :disabled="!provinsiCode && !!form.alamat.provinsi"></option>
        <template x-for="option in provinsiOptions" :key="option.value">
          <option :value="option.value" x-text="option.label"></option>
        </template>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Kabupaten / Kota</label>
      <select x-model="kabupatenCode" @change="onKabupatenChange()" :disabled="!provinsiCode || kabupatenLoading"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent disabled:bg-slate-100 disabled:text-slate-400">
        <option value="" x-text="kabupatenLoading ? 'Memuat kabupaten...' : (kabupatenCode ? 'Pilih kabupaten / kota' : (form.alamat.kabupaten || 'Pilih kabupaten / kota'))" :disabled="!kabupatenCode && !!form.alamat.kabupaten"></option>
        <template x-for="option in kabupatenOptions" :key="option.value">
          <option :value="option.value" x-text="option.label"></option>
        </template>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Kecamatan</label>
      <select x-model="kecamatanCode" @change="onKecamatanChange()" :disabled="!kabupatenCode || kecamatanLoading"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent disabled:bg-slate-100 disabled:text-slate-400">
        <option value="" x-text="kecamatanLoading ? 'Memuat kecamatan...' : (kecamatanCode ? 'Pilih kecamatan' : (form.alamat.kecamatan || 'Pilih kecamatan'))" :disabled="!kecamatanCode && !!form.alamat.kecamatan"></option>
        <template x-for="option in kecamatanOptions" :key="option.value">
          <option :value="option.value" x-text="option.label"></option>
        </template>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Desa / Kelurahan</label>
      <select x-model="desaCode" @change="onDesaChange()" :disabled="!kecamatanCode || desaLoading"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent disabled:bg-slate-100 disabled:text-slate-400">
        <option value="" x-text="desaLoading ? 'Memuat desa...' : (desaCode ? 'Pilih desa / kelurahan' : (form.alamat.desa || 'Pilih desa / kelurahan'))" :disabled="!desaCode && !!form.alamat.desa"></option>
        <template x-for="option in desaOptions" :key="option.value">
          <option :value="option.value" x-text="option.label"></option>
        </template>
      </select>
    </div>

    <x-form.input label="Patokan" model="form.alamat.patokan" placeholder="Dekat masjid / kantor desa" />
    <x-form.input label="Latitude" model="form.alamat.latitude" placeholder="-7.7839810" />
    <x-form.input label="Longitude" model="form.alamat.longitude" placeholder="109.9614240" />
  </div>
</section>