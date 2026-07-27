<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
          <th class="px-4 py-3">No. Peminjaman</th>
          <th class="px-4 py-3">Nama Peminjam</th>
          <th class="px-4 py-3">Tgl Pinjam</th>
          <th class="px-4 py-3">Rencana Kembali</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3 text-right">Aksi</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-slate-100">
        <template x-if="!loading && items.length === 0">
          <tr>
            <td colspan="6" class="px-4 py-10 text-center text-slate-400">Belum ada data peminjaman.</td>
          </tr>
        </template>

        <template x-for="item in items" :key="item.id">
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3 font-mono text-xs text-slate-500" x-text="item.nomor"></td>
            <td class="px-4 py-3 font-medium text-slate-800" x-text="item.nama_peminjam"></td>
            <td class="px-4 py-3 text-slate-600" x-text="item.tanggal_pinjam"></td>
            <td class="px-4 py-3 text-slate-600" x-text="item.tanggal_rencana_kembali || '—'"></td>
            <td class="px-4 py-3">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="statusBadge(item.status)"
                x-text="statusLabel(item.status)"></span>
            </td>
            <td class="px-4 py-3">
              <div class="flex items-center justify-end gap-2">
                {{-- Lihat Detail --}}
                <a :href="`/inventaris/peminjaman/${item.id}`" class="p-1.5 text-slate-400 hover:text-accent rounded-lg hover:bg-slate-100" title="Detail">
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm0 0 6-6M9 12 3 6" />
                  </svg>
                </a>

                {{-- Batalkan (hanya jika status dipinjam) --}}
                <template x-if="item.status === 'dipinjam'">
                  <button type="button" @click="openBatal(item)" class="p-1.5 text-slate-400 hover:text-orange-600 rounded-lg hover:bg-slate-100" title="Batalkan">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M6 18 18 6" />
                    </svg>
                  </button>
                </template>

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