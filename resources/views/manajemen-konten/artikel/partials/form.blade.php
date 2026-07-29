<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Informasi Artikel</h4>
    <p class="text-xs text-slate-400">Judul, penulis, dan konten artikel.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="Judul" model="form.judul" placeholder="Judul artikel" required />
    <x-form.input label="Slug" model="form.slug" placeholder="judul-artikel" hint="Kosongi untuk generate otomatis" />
    <x-form.input label="Nama Penulis" model="form.nama_penulis" placeholder="Nama penulis" required />
    <x-form.input label="Tahun" model="form.tahun" type="number" placeholder="2025" />
    <x-form.input label="Jumlah Halaman" model="form.jumlah_halaman" type="number" placeholder="128" />
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
      <select x-model="form.status"
              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        <option value="draft">Draft</option>
        <option value="published">Published</option>
      </select>
    </div>
  </div>

  <x-form.textarea label="Ringkasan" model="form.ringkasan" placeholder="Ringkasan artikel..." rows="3" />

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">File PDF</label>
      <input type="file" accept=".pdf" @change="onFileChange('pdf', $event)"
             class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Thumbnail</label>
      <input type="file" accept="image/*" @change="onFileChange('thumbnail', $event)"
             class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
    </div>
  </div>
</section>