@extends('layouts.app')

@section('title', 'Master Kategori Surat')
@section('page-title', 'Master Kategori Surat')
@section('page-subtitle', 'Kelola kategori surat yang tersedia untuk pengajuan surat.')

@section('content')
  <div x-data="kategoriSuratCrud" class="max-w-5xl mx-auto space-y-5">
    @include('components.alert')

    <x-master-data-toolbar
      title="Kategori Surat"
      description="Tambah, ubah, cari, dan hapus data kategori surat."
      searchPlaceholder="Cari kategori surat..."
      buttonLabel="Tambah Kategori" />

    @include('master-data.kategori-surat.partials.table')

    <x-modal max-width="max-w-xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Kategori Surat' : 'Tambah Kategori Surat'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-4">
        @include('master-data.kategori-surat.partials.form')
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

    <x-confirm-dialog title="Hapus kategori surat?" confirm="remove()">
      Data <strong x-text="deletingItem?.nama_kategori_surat"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection