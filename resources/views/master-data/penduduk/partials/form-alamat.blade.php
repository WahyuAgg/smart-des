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
    <x-form.input label="Desa" model="form.alamat.desa" placeholder="Nama desa" />
    <x-form.input label="Provinsi" model="form.alamat.provinsi" placeholder="Nama provinsi" />
    <x-form.input label="Kecamatan" model="form.alamat.kecamatan" placeholder="Nama kecamatan" />
    <x-form.input label="Kabupaten" model="form.alamat.kabupaten" placeholder="Nama kabupaten" />
    <x-form.input label="Patokan" model="form.alamat.patokan" placeholder="Dekat masjid / kantor desa" />
    <x-form.input label="Latitude" model="form.alamat.latitude" placeholder="-7.7839810" />
    <x-form.input label="Longitude" model="form.alamat.longitude" placeholder="109.9614240" />
  </div>
</section>