@extends('layouts.app')

@section('title', 'Master Perangkat Desa')
@section('page-title', 'Master Perangkat Desa')
@section('page-subtitle', 'Kelola data perangkat desa yang mengisi jabatan tertentu.')

@section('content')
  <div x-data="perangkatDesaCrud" class="max-w-5xl mx-auto space-y-5">
    @include('components.alert')

    <x-master-data-toolbar
      title="Perangkat Desa"
      description="Tambah, ubah, cari, dan hapus data perangkat desa."
      searchPlaceholder="Cari perangkat desa..."
      buttonLabel="Tambah Perangkat"
      searchWidth="sm:w-72" />

    @include('master-data.perangkat-desa.partials.table')

    <x-modal max-width="max-w-2xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Perangkat Desa' : 'Tambah Perangkat Desa'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-6">
        @include('master-data.perangkat-desa.partials.form')
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

    <x-confirm-dialog title="Hapus data perangkat?" confirm="remove()">
      Perangkat <strong x-text="deletingItem?.perangkat?.nama"></strong> dari jabatan <strong x-text="deletingItem?.nama"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection