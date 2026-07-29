<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
          <th class="px-4 py-3">#</th>
          <th class="px-4 py-3">Kode</th>
          <th class="px-4 py-3">Nama Jenis Surat</th>
          <th class="px-4 py-3">Kategori</th>
          <th class="px-4 py-3">Deskripsi</th>
          <th class="px-4 py-3">Template</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3 text-right">Aksi</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-slate-100">
        <template x-if="!loading && items.length === 0">
          <tr>
            <td colspan="8" class="px-4 py-10 text-center text-slate-400">Belum ada data jenis surat.</td>
          </tr>
        </template>

        <template x-for="(item, index) in items" :key="item.id">
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3 text-slate-400 text-xs" x-text="((meta.current_page - 1) * meta.per_page) + index + 1"></td>
            <td class="px-4 py-3 font-mono text-xs font-medium text-slate-800" x-text="item.kode_jenis_surat"></td>
            <td class="px-4 py-3 font-medium text-slate-800" x-text="item.nama_jenis_surat"></td>
            <td class="px-4 py-3 text-slate-600" x-text="item.srt_kategori_surat?.nama_kategori_surat || '—'"></td>
            <td class="px-4 py-3 text-slate-500 max-w-xs truncate" x-text="item.deskripsi || '—'"></td>
            <td class="px-4 py-3">
              <template x-if="item.template_pdf_url">
                <button type="button" @click="openPreview(item.template_pdf_url)"
                  class="inline-flex items-center gap-1.5 text-xs font-medium text-accent hover:text-accent-hover">
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l5 5-5 5M9 10l-5 5 5 5M4 4h16" />
                  </svg>
                  Preview
                </button>
              </template>
              <template x-if="!item.template_pdf_url">
                <span class="text-xs text-slate-400">—</span>
              </template>
            </td>
            <td class="px-4 py-3">
              <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium"
                :class="item.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'"
                x-text="item.is_active ? 'Aktif' : 'Nonaktif'"></span>
            </td>
            <td class="px-4 py-3">
              <div class="flex items-center justify-end gap-3">
                <button type="button" @click="openEdit(item)" class="text-slate-400 hover:text-accent" title="Edit">
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z" />
                  </svg>
                </button>
                <button type="button" @click="openDelete(item)" class="text-slate-400 hover:text-red-600" title="Hapus">
                  <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0-.8 13.2A2 2 0 0 1 16.2 21H7.8a2 2 0 0 1-2-1.8L5 6" />
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        </template>

        <template x-if="loading">
          <tr>
            <td colspan="8" class="px-4 py-10 text-center text-slate-400">Memuat data...</td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>

  @include('components.pagination')
</div>