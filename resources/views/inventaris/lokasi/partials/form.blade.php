<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Informasi Lokasi</h4>
    <p class="text-xs text-slate-400">Masukkan nama lokasi dan keterangan jika diperlukan.</p>
  </div>

  <div class="grid grid-cols-1 gap-4">
    <x-form.input label="Nama Lokasi" model="form.nama" placeholder="Contoh: Gudang Utama, Ruang Rapat, Aula" required />
    <x-form.textarea label="Keterangan" model="form.keterangan" placeholder="Opsional" rows="3" />
  </div>
</section>