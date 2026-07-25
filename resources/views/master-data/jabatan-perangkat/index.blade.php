@extends('layouts.app')

@section('title', 'Master Jabatan Perangkat')
@section('page-title', 'Master Jabatan Perangkat')
@section('page-subtitle', 'Kelola jabatan perangkat desa yang tersedia.')

@section('content')
  <div x-data="jabatanPerangkatCrud" class="max-w-4xl mx-auto space-y-5">
    @include('components.alert')

    <x-master-data-toolbar
      title="Jabatan Perangkat"
      description="Tambah, ubah, cari, dan hapus data jabatan perangkat desa."
      searchPlaceholder="Cari jabatan perangkat..."
      buttonLabel="Tambah Jabatan"
      searchWidth="sm:w-72" />

    @include('master-data.jabatan-perangkat.partials.table')

    <x-modal max-width="max-w-xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Jabatan' : 'Tambah Jabatan'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-6">
        @include('master-data.jabatan-perangkat.partials.form')
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

    <x-confirm-dialog title="Hapus data jabatan?" confirm="remove()">
      Jabatan <strong x-text="deletingItem?.nama"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection