<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Identitas KK</h4>
    <p class="text-xs text-slate-400">Masukkan nomor KK dan NIK kepala keluarga jika sudah tersedia.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="No. KK" model="form.no_kk" placeholder="16-17 digit nomor kartu keluarga" required />
    <x-form.input label="NIK Kepala Keluarga" model="form.nik_kepala_keluarga" placeholder="Opsional jika belum diisi" />
  </div>

  <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
    <p class="font-medium text-slate-800 mb-1">Catatan</p>
    <p>No. KK dipakai sebagai identitas utama kartu keluarga. Jika NIK kepala keluarga belum diketahui, data tetap bisa disimpan dan diperbarui nanti.</p>
  </div>
</section>