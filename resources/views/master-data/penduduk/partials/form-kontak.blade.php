<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Kontak & Status</h4>
    <p class="text-xs text-slate-400">Informasi kontak dan status kehidupan penduduk.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <x-form.input label="Kewarganegaraan" model="form.kewarganegaraan" placeholder="Indonesia" />
    <x-form.select label="Golongan Darah" model="form.golongan_darah" :options="[
      ['value' => 'A', 'label' => 'A'],
      ['value' => 'B', 'label' => 'B'],
      ['value' => 'AB', 'label' => 'AB'],
      ['value' => 'O', 'label' => 'O'],
      ['value' => '-', 'label' => '-'],
    ]" />
    <x-form.input label="No. HP" model="form.no_hp" placeholder="08xxxxxxxxxx" />
    <x-form.input type="email" label="Email" model="form.email" placeholder="nama@email.com" />
    <x-form.select label="Status Hidup" model="form.status_hidup" :nullable="false" :options="[
      ['value' => 'HIDUP', 'label' => 'Hidup'],
      ['value' => 'MENINGGAL', 'label' => 'Meninggal'],
    ]" hint="Nilai ini akan menentukan apakah tanggal meninggal perlu diisi." />
    <div x-show="form.status_hidup === 'MENINGGAL'">
      <x-form.input type="date" label="Tanggal Meninggal" model="form.tanggal_meninggal" />
    </div>
  </div>
</section>