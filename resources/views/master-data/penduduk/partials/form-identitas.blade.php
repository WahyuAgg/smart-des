<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Identitas</h4>
    <p class="text-xs text-slate-400">Data pokok untuk identifikasi penduduk.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="NIK" model="form.nik" placeholder="330602xxxxxxxxxx" required />
    <x-form.input label="Nama Lengkap" model="form.nama_lengkap" placeholder="Nama sesuai identitas" required />
    <x-form.select label="Jenis Kelamin" model="form.jenis_kelamin" :nullable="false" :options="[
      ['value' => 'Laki-laki', 'label' => 'Laki-laki'],
      ['value' => 'Perempuan', 'label' => 'Perempuan'],
    ]" required />
    <x-form.input label="Tempat Lahir" model="form.tempat_lahir" placeholder="Contoh: Purworejo" />
    <x-form.input type="date" label="Tanggal Lahir" model="form.tanggal_lahir" />
    <x-form.select label="Agama" model="form.agama" :nullable="false" :options="[
      ['value' => 'ISLAM', 'label' => 'Islam'],
      ['value' => 'KRISTEN', 'label' => 'Kristen'],
      ['value' => 'KATOLIK', 'label' => 'Katolik'],
      ['value' => 'HINDU', 'label' => 'Hindu'],
      ['value' => 'BUDHA', 'label' => 'Budha'],
      ['value' => 'KONGHUCU', 'label' => 'Konghucu'],
    ]" />
  </div>
</section>