<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Informasi Kategori Surat</h4>
    <p class="text-xs text-slate-400">Kode dan nama kategori surat harus unik.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="Kode Kategori" model="form.kode_kategori_surat" placeholder="Contoh: Gen" required />
    <x-form.input label="Nama Kategori" model="form.nama_kategori_surat" placeholder="Contoh: General" required />
  </div>

  <x-form.textarea label="Deskripsi" model="form.deskripsi" placeholder="Opsional deskripsi kategori surat" rows="3" />

  <x-form.select label="Status Aktif" model="form.is_active" :options="[['value' => true, 'label' => 'Aktif'], ['value' => false, 'label' => 'Nonaktif']]" :nullable="false" />
</section>