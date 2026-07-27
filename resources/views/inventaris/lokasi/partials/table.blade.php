<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
          <th class="px-4 py-3">Nama Lokasi</th>
          <th class="px-4 py-3">Keterangan</th>
          <th class="px-4 py-3">Jumlah Barang</th>
          <th class="px-4 py-3 text-right">Aksi</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-slate-100">
        <template x-if="!loading && items.length === 0">
          <tr>
            <td colspan="4" class="px-4 py-10 text-center text-slate-400">Belum ada data lokasi.</td>
          </tr>
        </template>

        <template x-for="item in items" :key="item.id">
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3">
              <div class="font-medium text-slate-800" x-text="item.nama"></div>
            </td>
            <td class="px-4 py-3 text-slate-600">
              <div x-text="item.keterangan || '—'"></div>
            </td>
            <td class="px-4 py-3 text-slate-600">
              <div x-text="item.barangs_count ?? 0"></div>
            </td>
            <td class="px-4 py-3">
              <div class="flex items-center justify-end gap-3">
                <button type="button" @click="openEdit(item)" class="text-slate-400 hover:text-accent" title="Edit">
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z" />
                  </svg>
                </button>
                <button type="button" @click="openDelete(item)" class="text-slate-400 hover:text-red-600" title="Hapus">
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0-.8 13.2A2 2 0 0 1 16.2 21H7.8a2 2 0 0 1-2-1.8L5 6" />
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