<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
          <th class="px-4 py-3">#</th>
          <th class="px-4 py-3">Tingkat Pendidikan</th>
          <th class="px-4 py-3 text-right">Aksi</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-slate-100">
        <template x-if="!loading && items.length === 0">
          <tr>
            <td colspan="3" class="px-4 py-10 text-center text-slate-400">Belum ada data pendidikan.</td>
          </tr>
        </template>

        <template x-for="(item, index) in items" :key="item.id">
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3 text-slate-400 text-xs" x-text="((meta.current_page - 1) * 10) + index + 1"></td>
            <td class="px-4 py-3 font-medium text-slate-800" x-text="item.tingkat_pendidikan"></td>
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

        <template x-if="loading">
          <tr>
            <td colspan="3" class="px-4 py-10 text-center text-slate-400">Memuat data...</td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>

  <div x-show="meta.last_page > 1"
    class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between px-4 py-3 border-t border-slate-200 text-xs text-slate-500">
    <span>Halaman <span x-text="meta.current_page"></span> dari <span x-text="meta.last_page"></span> · <span x-text="meta.total"></span> data</span>
    <div class="flex gap-2">
      <button type="button" @click="load(meta.current_page - 1)" :disabled="meta.current_page <= 1"
        class="px-3 py-1.5 rounded-md border border-slate-300 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed">Sebelumnya</button>
      <button type="button" @click="load(meta.current_page + 1)" :disabled="meta.current_page >= meta.last_page"
        class="px-3 py-1.5 rounded-md border border-slate-300 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed">Berikutnya</button>
    </div>
  </div>
</div>