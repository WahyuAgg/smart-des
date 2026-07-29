@extends('layouts.app')

@section('title', 'Manajemen Artikel')
@section('page-title', 'Manajemen Artikel')
@section('page-subtitle', 'Kelola artikel dan bacaan edukatif')

@section('content')
<div x-data="artikelCrud" class="max-w-7xl mx-auto space-y-5">
  @include('components.alert')

  <x-master-data-toolbar
    title="Artikel"
    description="Tambah, ubah, cari, dan hapus artikel edukatif."
    searchPlaceholder="Cari judul atau penulis..."
    buttonLabel="Tambah Artikel" />

  {{-- Table --}}
  <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
            <th class="px-4 py-3">#</th>
            <th class="px-4 py-3">Judul</th>
            <th class="px-4 py-3">Penulis</th>
            <th class="px-4 py-3">Tahun</th>
            <th class="px-4 py-3">Halaman</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <template x-if="!loading && items.length === 0">
            <tr>
              <td colspan="7" class="px-4 py-10 text-center text-slate-400">Belum ada artikel.</td>
            </tr>
          </template>
          <template x-for="(item, index) in items" :key="item.id">
            <tr class="hover:bg-slate-50">
              <td class="px-4 py-3 text-slate-400 text-xs" x-text="((meta.current_page - 1) * 10) + index + 1"></td>
              <td class="px-4 py-3 font-medium text-slate-800 max-w-xs truncate" x-text="item.judul"></td>
              <td class="px-4 py-3 text-slate-600" x-text="item.nama_penulis"></td>
              <td class="px-4 py-3 text-slate-600" x-text="item.tahun"></td>
              <td class="px-4 py-3 text-slate-600" x-text="item.jumlah_halaman"></td>
              <td class="px-4 py-3">
                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium"
                      :class="item.status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600'"
                      x-text="item.status === 'published' ? 'Published' : 'Draft'"></span>
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
              <td colspan="7" class="px-4 py-10 text-center text-slate-400">Memuat data...</td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    @include('components.pagination')
  </div>

  {{-- Modal Form --}}
  <x-modal max-width="max-w-3xl">
    <x-slot:title>
      <span x-text="editingId ? 'Edit Artikel' : 'Tambah Artikel'"></span>
    </x-slot:title>
    <form @submit.prevent="save()" class="space-y-6">
      @include('manajemen-konten.artikel.partials.form')
    </form>
    <x-slot:footer>
      <button type="button" @click="showModal = false"
        class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">Batal</button>
      <button type="button" @click="save()" :disabled="saving"
        class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover disabled:opacity-40">
        <span x-show="!saving" x-text="editingId ? 'Simpan Perubahan' : 'Simpan'"></span>
        <span x-show="saving">Menyimpan...</span>
      </button>
    </x-slot:footer>
  </x-modal>

  {{-- Confirm Delete --}}
  <x-confirm-dialog title="Hapus artikel?" confirm="remove()">
    Artikel <strong x-text="deletingItem?.judul"></strong> akan dihapus permanen.
  </x-confirm-dialog>
</div>
@endsection