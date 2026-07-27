<section class="space-y-6">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Informasi Barang</h4>
    <p class="text-xs text-slate-400">Lengkapi data barang inventaris desa.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="Kode Barang" model="form.kode_barang" placeholder="Contoh: BRG-00001" required />
    <x-form.input label="Nama Barang" model="form.nama_barang" placeholder="Contoh: Laptop, Meja, Kursi" required />

    {{-- Select Kategori (Alpine) --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
      <select x-model="form.kategori_id" required
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        <option value="">- Pilih Kategori -</option>
        <template x-for="kat in kategoriLookup.items" :key="kat.id">
          <option :value="kat.id" x-text="kat.nama"></option>
        </template>
      </select>
    </div>

    {{-- Select Lokasi (Alpine) --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
      <select x-model="form.lokasi_id" required
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        <option value="">- Pilih Lokasi -</option>
        <template x-for="lok in lokasiLookup.items" :key="lok.id">
          <option :value="lok.id" x-text="lok.nama"></option>
        </template>
      </select>
    </div>

    <x-form.input label="Satuan" model="form.satuan" placeholder="Contoh: Unit, Pcs, Buah" required />
    <x-form.input label="Tanggal Perolehan" model="form.tanggal_perolehan" type="date" />
  </div>

  <x-form.textarea label="Keterangan" model="form.keterangan" placeholder="Deskripsi barang..." rows="3" />

  <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
    <p class="font-medium text-slate-800 mb-1">Informasi Stok Awal</p>
    <p>Jumlah total awal barang akan dicatat saat pertama kali disimpan. Stok dapat ditambahkan nanti melalui fitur <strong>Pengadaan</strong>.</p>
  </div>

  <x-form.input label="Jumlah Total Awal" model="form.jumlah_total" type="number" placeholder="0" hint="Stok awal barang ini" />
</section>