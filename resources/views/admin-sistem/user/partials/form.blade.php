<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Informasi User</h4>
    <p class="text-xs text-slate-400">Data akun dan hak akses pengguna sistem.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="Nama Lengkap" model="form.name" placeholder="Nama pengguna" required />
    <x-form.input label="Email" model="form.email" type="email" placeholder="user@example.com" required />
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div x-show="!editingId">
      <x-form.input label="Password" model="form.password" type="password" placeholder="Minimal 8 karakter" required />
    </div>
    <div x-show="!editingId">
      <x-form.input label="Konfirmasi Password" model="form.password_confirmation" type="password" placeholder="Ulangi password" required />
    </div>
    <div x-show="editingId">
      <x-form.input label="Password Baru (opsional)" model="form.password" type="password" placeholder="Kosongi bila tidak diubah" hint="Isi hanya jika ingin mengganti password" />
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
      <select x-model="form.role"
              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        <option value="">-- Pilih Role --</option>
        <template x-for="opt in roleOptions" :key="opt.value">
          <option :value="opt.value" x-text="opt.label"></option>
        </template>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
      <select x-model="form.is_active"
              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        <option :value="true">Aktif</option>
        <option :value="false">Nonaktif</option>
      </select>
    </div>
  </div>
</section>