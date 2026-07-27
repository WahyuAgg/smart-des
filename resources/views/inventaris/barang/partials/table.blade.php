<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
          <th class="px-4 py-3">Kode</th>
          <th class="px-4 py-3">Nama Barang</th>
          <th class="px-4 py-3">Kategori</th>
          <th class="px-4 py-3">Lokasi</th>
          <th class="px-4 py-3">Satuan</th>
          <th class="px-4 py-3 text-right">Total</th>
          <th class="px-4 py-3 text-right">Dipinjam</th>
          <th class="px-4 py-3 text-right">Tersedia</th>
          <th class="px-4 py-3 text-center">Aksi</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-slate-100">
        <template x-if="!loading && items.length === 0">
          <tr>
            <td colspan="9" class="px-4 py-10 text-center text-slate-400">Belum ada data barang.</td>
          </tr>
        </template>

        <template x-for="item in items" :key="item.id">
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3 font-mono text-xs text-slate-500" x-text="item.kode_barang"></td>
            <td class="px-4 py-3">
              <a :href="`/inventaris/barang/${item.id}`" class="font-medium text-slate-800 hover:text-accent" x-text="item.nama_barang"></a>
            </td>
            <td class="px-4 py-3 text-slate-600" x-text="item.kategori?.nama || '—'"></td>
            <td class="px-4 py-3 text-slate-600" x-text="item.lokasi?.nama || '—'"></td>
            <td class="px-4 py-3 text-slate-600" x-text="item.satuan || '—'"></td>
            <td class="px-4 py-3 text-right font-medium" x-text="item.jumlah_total ?? 0"></td>
            <td class="px-4 py-3 text-right text-slate-600" x-text="item.jumlah_dipinjam ?? 0"></td>
            <td class="px-4 py-3 text-right">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="stokBadge(item)"
                x-text="stokTersedia(item)"></span>
            </td>
            <td class="px-4 py-3">
              <div class="flex items-center justify-center gap-1" x-data="{ open: false }">
                {{-- Tombol Aksi Stok --}}
                <div class="relative">
                  <button type="button" @click="open = !open" class="p-1.5 text-slate-400 hover:text-accent rounded-lg hover:bg-slate-100" title="Aksi Stok">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                    </svg>
                  </button>
                  <div x-show="open" @click.outside="open = false"
                    class="absolute right-0 mt-1 w-44 bg-white border border-slate-200 rounded-lg shadow-lg z-10 py-1 text-xs">
                    <button type="button" @click="openStockAction('pengadaan', item); open = false" class="w-full text-left px-3 py-2 hover:bg-slate-50">📦 Pengadaan</button>
                    <button type="button" @click="openStockAction('opname', item); open = false" class="w-full text-left px-3 py-2 hover:bg-slate-50">📋 Opname</button>
                    <button type="button" @click="openStockAction('hilang', item); open = false" class="w-full text-left px-3 py-2 hover:bg-slate-50">❌ Hilang</button>
                    <button type="button" @click="openStockAction('ketemu', item); open = false" class="w-full text-left px-3 py-2 hover:bg-slate-50">✅ Ketemu</button>
                    <button type="button" @click="openStockAction('hapus-stok', item); open = false" class="w-full text-left px-3 py-2 hover:bg-slate-50">🗑️ Hapus Stok</button>
                  </div>
                </div>

                {{-- Edit --}}
                <button type="button" @click="openEdit(item)" class="p-1.5 text-slate-400 hover:text-accent rounded-lg hover:bg-slate-100" title="Edit">
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z" />
                  </svg>
                </button>

                {{-- Hapus --}}
                <button type="button" @click="openDelete(item)" class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg hover:bg-slate-100" title="Hapus">
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0-.8 13.2A2 2 0 0 1 16.2 21H7.8a2 2 0 0 1-2-1.8L5 6" />
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>

  @include('components.pagination')
</div>