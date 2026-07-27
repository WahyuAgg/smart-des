@extends('layouts.app')

@section('title', 'Master Dusun')
@section('page-title', 'Master Dusun')
@section('page-subtitle', 'Kelola data dusun yang tersedia.')

@section('content')
  <div x-data="dusunCrud" class="max-w-4xl mx-auto space-y-5">
    @include('components.alert')

    <x-master-data-toolbar
      title="Dusun"
      description="Tambah, ubah, cari, dan hapus data dusun."
      searchPlaceholder="Cari nama dusun..."
      buttonLabel="Tambah Dusun" />

    @include('master-data.dusun.partials.table')

    <x-modal max-width="max-w-xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Dusun' : 'Tambah Dusun'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-4">
        @include('master-data.dusun.partials.form')
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

    <x-confirm-dialog title="Hapus dusun?" confirm="remove()">
      Data <strong x-text="deletingItem?.nama"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection