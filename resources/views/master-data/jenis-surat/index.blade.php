@extends('layouts.app')

@section('title', 'Master Jenis Surat')
@section('page-title', 'Master Jenis Surat')
@section('page-subtitle', 'Kelola jenis surat beserta template dan field penduduk terkait.')

@section('content')
  <div x-data="jenisSuratCrud" class="max-w-6xl mx-auto space-y-5">
    @include('components.alert')

    <x-master-data-toolbar
      title="Jenis Surat"
      description="Tambah, ubah, cari, dan hapus data jenis surat."
      searchPlaceholder="Cari jenis surat..."
      buttonLabel="Tambah Jenis Surat" />

    @include('master-data.jenis-surat.partials.table')

    <x-modal max-width="max-w-3xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Jenis Surat' : 'Tambah Jenis Surat'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-6">
        @include('master-data.jenis-surat.partials.form')
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

    {{-- Confirm dialog hapus --}}
    <x-confirm-dialog title="Hapus jenis surat?" confirm="remove()">
      Data <strong x-text="deletingItem?.nama_jenis_surat"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>

    {{-- Modal preview PDF --}}
    <div x-show="showPreview" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div x-show="showPreview" x-transition.opacity
           @click="closePreview()"
           class="absolute inset-0 bg-slate-900/60"></div>

      <div x-show="showPreview"
           x-transition:enter="transition ease-out duration-150"
           x-transition:enter-start="opacity-0 scale-95"
           x-transition:enter-end="opacity-100 scale-100"
           class="relative bg-white rounded-xl shadow-lg w-full max-w-4xl max-h-[90vh] flex flex-col">

        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
          <h3 class="text-sm font-semibold text-slate-800">Preview Template PDF</h3>
          <button type="button" @click="closePreview()" class="text-slate-400 hover:text-slate-600">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M6 18 18 6" />
            </svg>
          </button>
        </div>

        <div class="flex-1 p-2 min-h-[70vh]">
          <iframe :src="previewUrl" class="w-full h-[70vh] rounded-lg border border-slate-200" frameborder="0"></iframe>
        </div>

        <div class="px-5 py-4 border-t border-slate-200 flex justify-end gap-3">
          <a :href="previewUrl" target="_blank"
             class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover">
            Buka di Tab Baru
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection