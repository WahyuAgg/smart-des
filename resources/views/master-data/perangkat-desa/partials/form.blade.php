<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Data Perangkat Desa</h4>
    <p class="text-xs text-slate-400">Masukkan informasi perangkat desa yang mengisi jabatan tertentu.</p>
  </div>

  {{-- Jabatan select — inline HTML karena options berasal dari Alpine, bukan PHP --}}
  <div>
    <label class="block text-sm font-medium text-slate-700 mb-1">
      Jabatan Perangkat <span class="text-red-500">*</span>
    </label>
    <select
      x-model="form.jabatan_perangkat_id"
      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
    >
      <option value="">Pilih jabatan...</option>
      <template x-for="opt in jabatanOptions" :key="opt.value">
        <option :value="opt.value" x-text="opt.label"></option>
      </template>
    </select>
    <p class="mt-1 text-xs text-slate-400">Jabatan yang diisi oleh perangkat ini.</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <x-form.input
      label="Nama Lengkap"
      model="form.nama"
      placeholder="Contoh: Budi Santoso"
      required
      hint="Nama lengkap perangkat desa." />

    <x-form.input
      label="NIP"
      model="form.nip"
      placeholder="Nomor Induk Pegawai (opsional)" />
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <x-form.input
      label="Nomor Telepon"
      model="form.telepon"
      placeholder="Contoh: 081234567890" />

    <x-form.input
      label="Email"
      model="form.email"
      type="email"
      placeholder="contoh@email.com" />
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <x-form.input
      label="Tanggal Mulai"
      model="form.tanggal_mulai"
      type="date" />

    <x-form.input
      label="Tanggal Selesai"
      model="form.tanggal_selesai"
      type="date"
      hint="Kosongkan jika masih menjabat." />
  </div>

  <x-form.select
    label="Aktif"
    model="form.aktif"
    :options="[['label' => 'Aktif', 'value' => true], ['label' => 'Nonaktif', 'value' => false]]"
    required />
</section>