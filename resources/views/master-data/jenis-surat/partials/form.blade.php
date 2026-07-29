<section class="space-y-6">
  {{-- Informasi dasar --}}
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Informasi Jenis Surat</h4>
    <p class="text-xs text-slate-400">Lengkapi data dasar jenis surat.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">
        Kategori Surat <span class="text-red-500">*</span>
      </label>
      <select x-model="form.kategori_surat_id"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        <option value="">- Pilih -</option>
        <template x-for="opt in kategoriOptions" :key="opt.value">
          <option :value="opt.value" x-text="opt.label"></option>
        </template>
      </select>
    </div>

    <x-form.input label="Kode Jenis Surat" model="form.kode_jenis_surat"
      placeholder="Contoh: SKTM" required />
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="Nama Jenis Surat" model="form.nama_jenis_surat"
      placeholder="Contoh: Surat Keterangan Tidak Mampu" required />

    <x-form.select label="Status Aktif" model="form.is_active"
      :options="[['value' => true, 'label' => 'Aktif'], ['value' => false, 'label' => 'Nonaktif']]" :nullable="false" />
  </div>

  <x-form.textarea label="Deskripsi" model="form.deskripsi"
    placeholder="Opsional deskripsi jenis surat" rows="3" />

  {{-- Upload Template --}}
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Template Surat</h4>
    <p class="text-xs text-slate-400 mb-3">Unggah file template surat (.docx).</p>

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">
        File Template <span class="text-xs text-slate-400">(.docx)</span>
      </label>
      <input type="file" accept=".docx,.doc"
        @change="onTemplateChange($event)"
        class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent/10 file:text-accent hover:file:bg-accent/20" />
      <p class="mt-1 text-xs text-slate-400">Kosongkan jika tidak ingin mengubah template.</p>
    </div>
  </div>

  {{-- Penduduk Fields --}}
  <div>
    <div class="flex items-center justify-between mb-3">
      <div>
        <h4 class="text-sm font-semibold text-slate-800">Field Penduduk</h4>
        <p class="text-xs text-slate-400">Field data penduduk yang terkait dengan surat ini.</p>
      </div>
      <button type="button" @click="addPendudukField()"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-accent border border-accent hover:bg-accent/5">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
        </svg>
        Tambah Field
      </button>
    </div>

    <template x-if="form.penduduk_fields.length === 0">
      <p class="text-sm text-slate-400 italic">Belum ada field penduduk. Klik "Tambah Field" untuk menambahkan.</p>
    </template>

    <template x-for="(field, index) in form.penduduk_fields" :key="field.temp_id">
      <div class="flex items-start gap-3 p-4 mb-3 rounded-lg border border-slate-200 bg-slate-50">
        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kode <span class="text-red-500">*</span></label>
            <input type="text" x-model="field.kode" placeholder="Contoh: pelapor"
              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Label <span class="text-red-500">*</span></label>
            <input type="text" x-model="field.label" placeholder="Contoh: Pelapor"
              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
            <input type="text" x-model="field.deskripsi" placeholder="Opsional"
              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Wajib</label>
            <select x-model="field.wajib"
              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
              <option :value="true">Ya</option>
              <option :value="false">Tidak</option>
            </select>
          </div>
        </div>
        <button type="button" @click="removePendudukField(index)"
          class="shrink-0 mt-6 p-1.5 rounded-md text-slate-400 hover:text-red-600 hover:bg-red-50"
          title="Hapus field">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </template>
  </div>
</section>