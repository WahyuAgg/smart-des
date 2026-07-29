<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Informasi Galeri</h4>
    <p class="text-xs text-slate-400">Judul, deskripsi, dan foto galeri.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="Judul" model="form.judul" placeholder="Judul foto" required />
    <x-form.input label="Tanggal" model="form.tanggal" type="date" required />
  </div>

  <x-form.textarea label="Deskripsi" model="form.deskripsi" placeholder="Deskripsi foto..." rows="3" />

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">File Foto</label>
      <input type="file" accept="image/*" @change="onFileChange($event)"
             class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
      <p class="mt-1 text-xs text-slate-400">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Status Publikasi</label>
      <select x-model="form.is_published"
              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        <option value="1">Published</option>
        <option value="0">Draft</option>
      </select>
    </div>
  </div>
</section>