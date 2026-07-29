<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Data Jabatan Perangkat</h4>
    <p class="text-xs text-slate-400">Masukkan informasi jabatan perangkat desa.</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <x-form.input
      label="Kode Jabatan"
      model="form.kode"
      placeholder="Contoh: KADES"
      required
      hint="Kode unik untuk jabatan." />

    <x-form.input
      label="Nama Jabatan"
      model="form.nama"
      placeholder="Contoh: Kepala Desa"
      required
      hint="Nama lengkap jabatan." />
  </div>

  <x-form.textarea
    label="Deskripsi"
    model="form.deskripsi"
    placeholder="Deskripsi jabatan (opsional)"
    :rows="2" />

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <x-form.input
      label="Urutan"
      model="form.urutan"
      type="number"
      placeholder="Contoh: 1"
      required
      hint="Urutan tampilan, semakin kecil semakin atas." />

    <x-form.select
      label="Aktif"
      model="form.aktif"
      :options="[['label' => 'Aktif', 'value' => true], ['label' => 'Nonaktif', 'value' => false]]"
      required
      hint="Status aktif jabatan." />

    {{-- <x-form.select
      label="Dapat Menandatangani"
      display="none"
      model="form.dapat_menandatangani"
      :options="[['label' => 'Ya', 'value' => 1], ['label' => 'Tidak', 'value' => 0]]"
      required
      hint="Apakah jabatan ini bisa menandatangani surat." /> --}}
  </div>
</section>