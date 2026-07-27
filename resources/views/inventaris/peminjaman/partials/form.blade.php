<section class="space-y-6">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Data Peminjam</h4>
    <p class="text-xs text-slate-400">Isi data peminjam dan barang yang dipinjam.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-slate-700 mb-1">Nama Peminjam <span class="text-red-500">*</span></label>
      <input type="text" x-model="form.nama_peminjam" placeholder="Nama lengkap peminjam"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
    </div>
    <x-form.input label="Tanggal Pinjam" model="form.tanggal_pinjam" type="date" required />
    <x-form.input label="Rencana Kembali" model="form.tanggal_rencana_kembali" type="date" required />
  </div>

  <x-form.textarea label="Keterangan" model="form.keterangan" placeholder="Catatan peminjaman..." rows="2" />

  {{-- Dynamic Rows Barang --}}
  <div>
    <div class="flex items-center justify-between mb-2">
      <h4 class="text-sm font-semibold text-slate-800">Barang yang Dipinjam</h4>
      <button type="button" @click="addDetailRow()" class="text-xs text-accent hover:text-accent-hover font-medium">+ Tambah Barang</button>
    </div>

    <template x-for="(row, idx) in form.details" :key="idx">
      <div class="flex items-end gap-3 mb-3">
        <div class="flex-1">
          <label class="block text-xs font-medium text-slate-700 mb-1">Barang</label>
          <select x-model="row.barang_id"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
            <option value="">- Pilih Barang -</option>
            <template x-for="brg in barangLookup.items" :key="brg.id">
              <option :value="brg.id" x-text="`${brg.nama_barang} (${brg.kode_barang}) — tersedia: ${(brg.jumlah_total||0) - (brg.jumlah_dipinjam||0)} ${brg.satuan||''}`"></option>
            </template>
          </select>
        </div>
        <div class="w-24">
          <label class="block text-xs font-medium text-slate-700 mb-1">Jumlah</label>
          <input type="number" x-model="row.jumlah" min="1" placeholder="0"
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        </div>
        <button type="button" @click="removeDetailRow(idx)" x-show="form.details.length > 1"
          class="p-2 text-slate-400 hover:text-red-600 mb-1">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M6 18 18 6" />
          </svg>
        </button>
      </div>
    </template>
  </div>
</section>