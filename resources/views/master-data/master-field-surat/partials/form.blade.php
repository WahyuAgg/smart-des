<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Informasi Field</h4>
    <p class="text-xs text-slate-400">Field ini akan dipakai sebagai placeholder di template surat.</p>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <x-form.input label="Nama (key)" model="form.nama" placeholder="cth: nama_pelapor" required
      hint="Dipakai sebagai placeholder di template, tanpa spasi." />
    <x-form.input label="Label" model="form.label" placeholder="cth: Nama Pelapor" required />
  </div>

  <div class="grid grid-cols-2 gap-4">
    <x-form.select label="Tipe" model="form.tipe" required :nullable="false" :options="[
        ['value' => 'text', 'label' => 'Teks'],
        ['value' => 'number', 'label' => 'Angka'],
        ['value' => 'date', 'label' => 'Tanggal'],
        ['value' => 'textarea', 'label' => 'Teks Panjang'],
    ]" />
    <x-form.select label="Input Mode" model="form.input_mode" required :nullable="false" :options="[
        ['value' => 'auto', 'label' => 'Otomatis'],
        ['value' => 'manual', 'label' => 'Manual'],
        ['value' => 'auto_editable', 'label' => 'Otomatis (bisa diedit)'],
    ]" />
  </div>

  <x-form.input label="Placeholder" model="form.placeholder" placeholder="cth: Masukkan nama pelapor" />

  <div class="grid grid-cols-2 gap-4">
    <x-form.select label="Source" model="form.source" placeholder="- Tidak ada -" :options="[
        ['value' => 'penduduk', 'label' => 'Penduduk'],
        ['value' => 'system', 'label' => 'System'],
        ['value' => 'profil_desa', 'label' => 'Profil Desa'],
        ['value' => 'jenis_surat', 'label' => 'Jenis Surat'],
    ]" />
    <x-form.input label="Source Field" model="form.source_field" placeholder="cth: nik" x-show="form.source"
      hint="Nama kolom pada sumber data di atas." />
  </div>

  <x-form.textarea label="Keterangan" model="form.keterangan" placeholder="Catatan tambahan (opsional)" />
</section>