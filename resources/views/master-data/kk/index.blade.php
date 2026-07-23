@extends('layouts.app')

@section('title', 'Master KK')
@section('page-title', 'Master Kartu Keluarga')
@section('page-subtitle', 'Kelola data kartu keluarga secara cepat, rapi, dan terpisah per komponen tampilan.')

@section('content')
  <div x-data="kkCrud" class="max-w-6xl mx-auto space-y-5">
    @include('components.alert')

    @include('master-data.kk.partials.toolbar')
    @include('master-data.kk.partials.table')

    <x-modal max-width="max-w-xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit KK' : 'Tambah KK'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-6">
        @include('master-data.kk.partials.form')
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

    <x-confirm-dialog title="Hapus KK?" confirm="remove()">
      Data <strong x-text="deletingItem?.no_kk"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection