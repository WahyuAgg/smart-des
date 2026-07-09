@extends('layouts.app')

@section('title', 'Master Field Surat')
@section('page-title', 'Master Field Surat')
@section('page-subtitle', 'Kelola daftar field yang bisa dipakai di template surat')

@section('content')
  <div x-data="masterFieldSurat" class="max-w-5xl mx-auto">

    @include('components.alert')

    {{-- header: search + tambah --}}
    <div class="flex items-center justify-between gap-3 mb-4">
      <div class="relative w-full max-w-xs">
        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
        </svg>
        <input type="text" x-model="search" @input.debounce.400ms="load(1)" placeholder="Cari nama atau label..."
          class="w-full pl-9 pr-3 py-2 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
      </div>

      <button type="button" @click="openCreate()"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover shrink-0">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
        </svg>
        Tambah Field
      </button>
    </div>

    {{-- table --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr
              class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
              <th class="px-4 py-3">Nama</th>
              <th class="px-4 py-3">Label</th>
              <th class="px-4 py-3">Tipe</th>
              <th class="px-4 py-3">Input Mode</th>
              <th class="px-4 py-3">Source</th>
              <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <template x-if="!loading && items.length === 0">
              <tr>
                <td colspan="6" class="px-4 py-10 text-center text-slate-400">Belum ada data field surat.
                </td>
              </tr>
            </template>

            <template x-for="item in items" :key="item.id">
              <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-mono text-xs text-slate-700" x-text="item.nama"></td>
                <td class="px-4 py-3 text-slate-700" x-text="item.label"></td>
                <td class="px-4 py-3 text-slate-500" x-text="item.tipe"></td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium"
                    :class="inputModeBadge(item.input_mode)" x-text="inputModeLabel(item.input_mode)"></span>
                </td>
                <td class="px-4 py-3 text-slate-500" x-text="item.source || '—'"></td>
                <td class="px-4 py-3">
                  <div class="flex items-center justify-end gap-3">
                    <button type="button" @click="openEdit(item)" class="text-slate-400 hover:text-accent"
                      title="Edit">
                      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z" />
                      </svg>
                    </button>
                    <button type="button" @click="openDelete(item)" class="text-slate-400 hover:text-red-600"
                      title="Hapus">
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
                <td colspan="6" class="px-4 py-10 text-center text-slate-400">Memuat data...</td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>

      {{-- pagination --}}
      <div x-show="meta.last_page > 1"
        class="flex items-center justify-between px-4 py-3 border-t border-slate-200 text-xs text-slate-500">
        <span>Halaman <span x-text="meta.current_page"></span> dari <span x-text="meta.last_page"></span> &middot;
          <span x-text="meta.total"></span> data</span>
        <div class="flex gap-2">
          <button type="button" @click="load(meta.current_page - 1)" :disabled="meta.current_page <= 1"
            class="px-3 py-1.5 rounded-md border border-slate-300 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed">Sebelumnya</button>
          <button type="button" @click="load(meta.current_page + 1)" :disabled="meta.current_page >= meta.last_page"
            class="px-3 py-1.5 rounded-md border border-slate-300 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed">Berikutnya</button>
        </div>
      </div>
    </div>

    {{-- modal create/edit --}}
    <x-modal max-width="max-w-xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Field Surat' : 'Tambah Field Surat'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <x-form.input label="Nama (key)" model="form.nama" placeholder="cth: nama_pelapor" required
            hint="Dipakai sebagai placeholder di template, tanpa spasi." />
          <x-form.input label="Label" model="form.label" placeholder="cth: Nama Pelapor" required />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <x-form.select label="Tipe" model="form.tipe" required :nullable="false" :options="[
              ['value' => 'text', 'label' => 'Teks'],
              ['value' => 'number', 'label' => 'Angka'],
              ['value' => 'date', 'label' => 'Tanggal'],
              ['value' => 'textarea', 'label' => 'Teks Panjang'],
          ]" />
          <x-form.select label="Input Mode" model="form.input_mode" required :nullable="false" :options="[
              ['value' => 'auto', 'label' => 'Otomatis'],
              ['value' => 'manual', 'label' => 'Manual'],
              ['value' => 'auto_editable', 'label' => 'Otomatis (bisa diedit)'],
          ]" />
        </div>

        <x-form.input label="Placeholder" model="form.placeholder" placeholder="cth: Masukkan nama pelapor" />

        <div class="grid grid-cols-2 gap-4">
          <x-form.select label="Source" model="form.source" placeholder="- Tidak ada -" :options="[
              ['value' => 'penduduk', 'label' => 'Penduduk'],
              ['value' => 'system', 'label' => 'System'],
              ['value' => 'profil_desa', 'label' => 'Profil Desa'],
              ['value' => 'jenis_surat', 'label' => 'Jenis Surat'],
          ]" />
          <x-form.input label="Source Field" model="form.source_field" placeholder="cth: nik" x-show="form.source"
            hint="Nama kolom pada sumber data di atas." />
        </div>

        <x-form.textarea label="Keterangan" model="form.keterangan" placeholder="Catatan tambahan (opsional)" />
      </form>

      <x-slot:footer>
        <button type="button" @click="showModal = false"
          class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">
          Batal
        </button>
        <button type="button" @click="save()" :disabled="saving"
          class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover disabled:opacity-40">
          <span x-show="!saving" x-text="editingId ? 'Simpan Perubahan' : 'Simpan'"></span>
          <span x-show="saving">Menyimpan...</span>
        </button>
      </x-slot:footer>
    </x-modal>

    {{-- confirm delete --}}
    <x-confirm-dialog title="Hapus field surat?" confirm="remove()">
      Data <strong x-text="deletingItem?.label"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>

  </div>
@endsection

<!-- @push('scripts')
  <script>
    window.API_BASE_URL = window.API_BASE_URL ||
      "{{ rtrim(config('services.surat.base_url', env('SURAT_API_URL', url('/api'))), '/') }}";
  </script>
  @vite('resources/js/master-field-surat.js')
@endpush -->
