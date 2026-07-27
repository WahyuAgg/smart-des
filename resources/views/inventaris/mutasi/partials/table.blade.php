<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
          <th class="px-4 py-3">No. Mutasi</th>
          <th class="px-4 py-3">Tanggal</th>
          <th class="px-4 py-3">Jenis</th>
          <th class="px-4 py-3">Keterangan</th>
          <th class="px-4 py-3 text-right">Aksi</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-slate-100">
        <template x-if="!loading && items.length === 0">
          <tr>
            <td colspan="5" class="px-4 py-10 text-center text-slate-400">Belum ada data mutasi.</td>
          </tr>
        </template>

        <template x-for="item in items" :key="item.id">
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3 font-mono text-xs text-slate-500" x-text="item.nomor"></td>
            <td class="px-4 py-3 text-slate-600" x-text="item.tanggal"></td>
            <td class="px-4 py-3">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="jenisBadge(item.jenis)"
                x-text="jenisLabel(item.jenis)"></span>
            </td>
            <td class="px-4 py-3 text-slate-600 max-w-xs truncate" x-text="item.keterangan || '—'"></td>
            <td class="px-4 py-3 text-right">
              <a :href="`/inventaris/mutasi/${item.id}`" class="p-1.5 text-slate-400 hover:text-accent rounded-lg hover:bg-slate-100 inline-block" title="Detail">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm0 0 6-6M9 12 3 6" />
                </svg>
              </a>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</div>