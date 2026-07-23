@extends('layouts.app')

@section('title', 'Master Penduduk')
@section('page-title', 'Master Penduduk')
@section('page-subtitle', 'Kelola data penduduk desa, lengkap dengan pencarian dan CRUD.')

@section('content')
  <div x-data="pendudukCrud" class="max-w-7xl mx-auto space-y-5">
    @include('components.alert')

    <x-master-data-toolbar
      title="Penduduk"
      description="Tambah, ubah, cari, dan hapus data penduduk dari satu halaman."
      searchPlaceholder="Cari NIK, nama, email, atau nomor HP..."
      buttonLabel="Tambah Penduduk" />

    @include('master-data.penduduk.partials.table')

    <x-modal max-width="max-w-5xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Penduduk' : 'Tambah Penduduk'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-6">
        @include('master-data.penduduk.partials.form-identitas')
        @include('master-data.penduduk.partials.form-keluarga')
        @include('master-data.penduduk.partials.form-kontak')
        @include('master-data.penduduk.partials.form-alamat')
        @include('master-data.penduduk.partials.form-lookup')
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

    <x-confirm-dialog title="Hapus penduduk?" confirm="remove()">
      Data <strong x-text="deletingItem?.nama_lengkap"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection