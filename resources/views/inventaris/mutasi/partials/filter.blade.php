<div class="bg-white border border-slate-200 rounded-xl p-4 mb-4">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
    <div>
      <label class="block text-xs font-medium text-slate-700 mb-1">Jenis Mutasi</label>
      <select x-model="filterJenis" @change="load(1)"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-accent">
        <option value="">Semua</option>
        <option value="pengadaan">Pengadaan</option>
        <option value="peminjaman">Peminjaman</option>
        <option value="pengembalian">Pengembalian</option>
        <option value="hilang">Hilang</option>
        <option value="ketemu">Ketemu</option>
        <option value="opname">Opname</option>
        <option value="hapus_stok">Hapus Stok</option>
        <option value="pembatalan">Pembatalan</option>
      </select>
    </div>
    <div>
      <label class="block text-xs font-medium text-slate-700 mb-1">Tanggal Dari</label>
      <input type="date" x-model="filterTanggalFrom" @change="load(1)"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
    </div>
    <div>
      <label class="block text-xs font-medium text-slate-700 mb-1">Tanggal Sampai</label>
      <input type="date" x-model="filterTanggalTo" @change="load(1)"
        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
    </div>
    <div class="flex items-end">
      <button type="button" @click="filterJenis = ''; filterTanggalFrom = ''; filterTanggalTo = ''; load(1)"
        class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">
        Reset Filter
      </button>
    </div>
  </div>
</div>