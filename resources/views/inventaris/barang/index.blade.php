@extends('layouts.app')

@section('title', 'Daftar Barang')
@section('page-title', 'Daftar Barang Inventaris')
@section('page-subtitle', 'Kelola barang inventaris desa: tambah, edit, cari, dan kelola stok.')

@section('content')
  <div x-data="barangCrud" class="max-w-7xl mx-auto space-y-5">
    @include('components.alert')

    <x-master-data-toolbar
      title="Barang Inventaris"
      description="Tambah, ubah, cari, hapus, dan kelola stok barang dari satu halaman."
      searchPlaceholder="Cari kode barang, nama, kategori, atau lokasi..."
      buttonLabel="Tambah Barang" />

    @include('inventaris.barang.partials.table')

    {{-- Modal Form Tambah/Edit Barang --}}
    <x-modal max-width="max-w-3xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Barang' : 'Tambah Barang'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-6">
        @include('inventaris.barang.partials.form')
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

    {{-- Modal Aksi Stok --}}
    @include('inventaris.barang.partials.modal-pengadaan')
    @include('inventaris.barang.partials.modal-hilang')
    @include('inventaris.barang.partials.modal-ketemu')
    @include('inventaris.barang.partials.modal-opname')
    @include('inventaris.barang.partials.modal-hapus-stok')

    <x-confirm-dialog title="Hapus barang?" confirm="remove()">
      Data <strong x-text="deletingItem?.nama_barang"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection