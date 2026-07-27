@extends('layouts.app')

@section('title', 'Master RW')
@section('page-title', 'Master RW')
@section('page-subtitle', 'Kelola data RW (Rukun Warga) di setiap dusun.')

@section('content')
  <div x-data="rwCrud" class="max-w-5xl mx-auto space-y-5">
    @include('components.alert')

    <x-master-data-toolbar
      title="RW"
      description="Tambah, ubah, cari, dan hapus data RW."
      searchPlaceholder="Cari nomor RW..."
      buttonLabel="Tambah RW" />

    @include('master-data.rw.partials.table')

    <x-modal max-width="max-w-xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit RW' : 'Tambah RW'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-4">
        @include('master-data.rw.partials.form')
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

    <x-confirm-dialog title="Hapus RW?" confirm="remove()">
      Data RW <strong x-text="deletingItem?.nomor_rw"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection