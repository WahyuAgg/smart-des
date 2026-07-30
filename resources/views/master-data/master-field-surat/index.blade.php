@extends('layouts.app')

@section('title', 'Master Field Surat')
@section('page-title', 'Master Field Surat')
@section('page-subtitle', 'Kelola daftar field yang bisa dipakai di template surat')

@section('content')
  <div x-data="masterFieldSurat" class="max-w-5xl mx-auto space-y-5">
    @include('components.alert')

    {{-- Peringatan: edit field berbahaya --}}
    <div class="rounded-lg border border-amber-300 bg-amber-50 px-4 py-3 text-sm text-amber-800">
      <div class="flex items-start gap-3">
        <svg class="w-5 h-5 mt-0.5 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
          <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        <div>
          <strong class="font-semibold">Peringatan!</strong> Mengedit atau menghapus <strong>field surat</strong> yang sudah terpakai di template dapat <strong>merusak sistem pembuatan surat</strong>. Hanya lakukan jika Anda benar-benar yakin.
        </div>
      </div>
    </div>

    <x-master-data-toolbar
      title="Master Field Surat"
      description="Kelola daftar field yang bisa dipakai di template surat."
      searchPlaceholder="Cari nama, label, atau source field..."
      buttonLabel="Tambah Field" />

    {{-- Filter --}}
    <div class="flex flex-wrap gap-3">
      <select x-model="filterTipe" @change="load(1)"
        class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        <option value="">Semua Tipe</option>
        <option value="text">Teks</option>
        <option value="number">Angka</option>
        <option value="date">Tanggal</option>
        <option value="textarea">Teks Panjang</option>
      </select>

      <select x-model="filterInputMode" @change="load(1)"
        class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        <option value="">Semua Input Mode</option>
        <option value="auto">Otomatis</option>
        <option value="manual">Manual</option>
        <option value="auto_editable">Otomatis (bisa diedit)</option>
      </select>

      <select x-model="filterSource" @change="load(1)"
        class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
        <option value="">Semua Source</option>
        <option value="penduduk">Penduduk</option>
        <option value="system">System</option>
        <option value="profil_desa">Profil Desa</option>
        <option value="jenis_surat">Jenis Surat</option>
      </select>
    </div>

    @include('master-data.master-field-surat.partials.table')

    <x-modal max-width="max-w-xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Field Surat' : 'Tambah Field Surat'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-4">
        @include('master-data.master-field-surat.partials.form')
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

    <x-confirm-dialog title="Hapus field surat?" confirm="remove()">
      Data <strong x-text="deletingItem?.label"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection

