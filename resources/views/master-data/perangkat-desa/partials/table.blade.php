<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
          <th class="px-4 py-3">#</th>
          <th class="px-4 py-3">Jabatan</th>
          <th class="px-4 py-3">Nama Perangkat</th>
          <th class="px-4 py-3">NIP</th>
          <th class="px-4 py-3">Telepon</th>
          <th class="px-4 py-3">Aktif</th>
          <th class="px-4 py-3 text-right">Aksi</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-slate-100">
        <template x-if="!loading && items.length === 0">
          <tr>
            <td colspan="7" class="px-4 py-10 text-center text-slate-400">Belum ada data perangkat desa.</td>
          </tr>
        </template>

        <template x-for="(item, index) in items" :key="item.kode">
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3 text-slate-400 text-xs" x-text="((meta.current_page - 1) * meta.per_page) + index + 1"></td>
            <td class="px-4 py-3">
              <div class="font-medium text-slate-800" x-text="item.nama"></div>
              <div class="text-xs text-slate-400 font-mono" x-text="item.kode"></div>
            </td>
            <td class="px-4 py-3">
              <template x-if="item.perangkat">
                <span class="font-medium text-slate-800" x-text="item.perangkat.nama"></span>
              </template>
              <template x-if="!item.perangkat">
                <span class="text-slate-400 italic">—</span>
              </template>
            </td>
            <td class="px-4 py-3 text-slate-500 text-xs font-mono" x-text="item.perangkat?.nip || '-'"></td>
            <td class="px-4 py-3 text-slate-500" x-text="item.perangkat?.telepon || '-'"></td>
            <td class="px-4 py-3">
              <span x-show="item.aktif"
                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                Aktif
              </span>
              <span x-show="!item.aktif"
                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                Nonaktif
              </span>
            </td>
            <td class="px-4 py-3">
              <div class="flex items-center justify-end gap-3">
                <template x-if="item.perangkat">
                  <button type="button" @click="openEdit(item)" class="text-slate-400 hover:text-accent" title="Edit">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z" />
                    </svg>
                  </button>
                </template>
                <template x-if="!item.perangkat">
                  <button type="button" @click="openCreateWithJabatan(item)" class="text-slate-400 hover:text-green-600" title="Tambah perangkat untuk jabatan ini">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                    </svg>
                  </button>
                </template>
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
            <td colspan="7" class="px-4 py-10 text-center text-slate-400">Memuat data...</td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>

  @include('components.pagination')
</div>