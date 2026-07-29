@extends('layouts.app')

@section('title', 'Manajemen Galeri')
@section('page-title', 'Manajemen Galeri')
@section('page-subtitle', 'Kelola foto dan dokumentasi desa')

@section('content')
<div x-data="galeriCrud" class="max-w-7xl mx-auto space-y-5">
  @include('components.alert')

  <x-master-data-toolbar
    title="Galeri"
    description="Tambah, ubah, cari, dan hapus foto galeri desa."
    searchPlaceholder="Cari judul atau deskripsi..."
    buttonLabel="Tambah Foto" />

  {{-- Loading --}}
  <div x-show="loading" x-cloak class="flex items-center justify-center py-16">
    <svg class="animate-spin h-8 w-8 text-accent" viewBox="0 0 24 24" fill="none">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
    </svg>
  </div>

  {{-- Error --}}
  <div x-show="!loading && error" x-cloak class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <p class="text-lg font-medium text-slate-600" x-text="error"></p>
    <button @click="load()" class="mt-4 px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover">Coba Lagi</button>
  </div>

  {{-- Grid View --}}
  <template x-if="!loading && !error">
    <div>
      {{-- Empty state --}}
      <div x-show="items.length === 0" class="text-center py-16 text-slate-400">
        <svg class="w-16 h-16 mx-auto mb-3 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
          <circle cx="8.5" cy="8.5" r="1.5" />
          <path d="m21 15-5-5L5 21" />
        </svg>
        <p class="text-base">Belum ada data galeri.</p>
      </div>

      {{-- Grid cards --}}
      <div x-show="items.length > 0"
           class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <template x-for="(item, index) in items" :key="item.id">
          <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col group
                      hover:shadow-md transition-shadow duration-200">

            {{-- Image preview --}}
            <div class="aspect-[4/3] bg-slate-100 overflow-hidden relative">
              <img :src="item.image_url"
                   :alt="item.judul"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                   loading="lazy" />

              {{-- Status badge --}}
              <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider shadow-sm"
                    :class="item.is_published
                      ? 'bg-emerald-500/80 text-white'
                      : 'bg-slate-500/80 text-white'"
                    x-text="item.is_published ? 'Published' : 'Draft'"></span>
            </div>

            {{-- Content --}}
            <div class="p-4 flex flex-col flex-1">
              <h3 class="text-sm font-semibold text-slate-800 line-clamp-1" x-text="item.judul"></h3>
              <p class="text-xs text-slate-500 mt-1 line-clamp-2" x-text="item.deskripsi || '—'"></p>
              <p class="text-[10px] text-slate-400 mt-1" x-text="$formatDate(item.tanggal)"></p>

              {{-- Actions --}}
              <div class="mt-auto pt-3 flex items-center justify-end gap-2 border-t border-slate-100">
                <button type="button" @click="openEdit(item)"
                        class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-colors">
                  Edit
                </button>
                <button type="button" @click="openDelete(item)"
                        class="px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition-colors">
                  Hapus
                </button>
              </div>
            </div>
          </div>
        </template>
      </div>

      {{-- Pagination --}}
      @include('components.pagination')
    </div>
  </template>

  {{-- Modal Form --}}
  <x-modal max-width="max-w-3xl">
    <x-slot:title>
      <span x-text="editingId ? 'Edit Foto' : 'Tambah Foto'"></span>
    </x-slot:title>
    <form @submit.prevent="save()" class="space-y-6">
      @include('manajemen-konten.galeri.partials.form')
    </form>
    <x-slot:footer>
      <button type="button" @click="showModal = false"
        class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">Batal</button>
      <button type="button" @click="save()" :disabled="saving"
        class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover disabled:opacity-40">
        <span x-show="!saving" x-text="editingId ? 'Simpan Perubahan' : 'Simpan'"></span>
        <span x-show="saving">Menyimpan...</span>
      </button>
    </x-slot:footer>
  </x-modal>

  {{-- Confirm Delete --}}
  <x-confirm-dialog title="Hapus foto?" confirm="remove()">
    Foto <strong x-text="deletingItem?.judul"></strong> akan dihapus permanen.
  </x-confirm-dialog>
</div>
@endsection