<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Keluarga & Pendidikan</h4>
    <p class="text-xs text-slate-400">Relasi keluarga dan pendidikan formal.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <x-form.input label="Nama Ayah Kandung" model="form.nama_ayah_kandung" placeholder="Nama ayah" />
    <x-form.input label="Nama Ibu Kandung" model="form.nama_ibu_kandung" placeholder="Nama ibu" />
    <x-form.select label="Status Perkawinan" model="form.status_perkawinan" :options="[
      ['value' => 'Belum Kawin', 'label' => 'Belum Kawin'],
      ['value' => 'Kawin Tercatat', 'label' => 'Kawin Tercatat'],
      ['value' => 'Kawin Belum Tercatat', 'label' => 'Kawin Belum Tercatat'],
      ['value' => 'Cerai Hidup', 'label' => 'Cerai Hidup'],
      ['value' => 'Cerai Mati', 'label' => 'Cerai Mati'],
    ]" />
    <x-form.input label="Pekerjaan" model="form.pekerjaan" placeholder="Contoh: Petani/Pekebun" />
  </div>
</section>