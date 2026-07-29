@extends('layouts.app')

@section('title', 'Galeri Foto')
@section('page-title', 'Galeri Foto')
@section('page-subtitle', 'Dokumentasi kegiatan dan momen desa')

@section('content')
<div x-data="galeri" class="max-w-7xl mx-auto space-y-6">

  {{-- Search --}}
  <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-end justify-between">
    <div class="relative w-full sm:w-80">
      <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
      </svg>
      <input type="text" x-model="search" @input.debounce.400ms="load(1)"
             placeholder="Cari judul atau deskripsi..."
             class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
    </div>
  </div>

  {{-- Loading --}}
  <div x-show="loading" x-cloak class="flex items-center justify-center py-20">
    <svg class="animate-spin h-10 w-10 text-accent" viewBox="0 0 24 24" fill="none">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
    </svg>
  </div>

  {{-- Error --}}
  <div x-show="!loading && error" x-cloak class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <p class="text-lg font-medium text-slate-600" x-text="error"></p>
    <button @click="load()" class="mt-4 px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover">Coba Lagi</button>
  </div>

  {{-- Grid --}}
  <template x-if="!loading && !error">
    <div>
      {{-- Empty state --}}
      <div x-show="items.length === 0" class="text-center py-20 text-slate-400">
        <svg class="w-20 h-20 mx-auto mb-4 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
          <circle cx="8.5" cy="8.5" r="1.5" />
          <path d="m21 15-5-5L5 21" />
        </svg>
        <p class="text-base font-medium">Belum ada foto galeri.</p>
        <p class="text-sm mt-1">Foto-foto dokumentasi desa akan tampil di sini.</p>
      </div>

      {{-- Photo Grid -- Masonry-style --}}
      <div x-show="items.length > 0"
           class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 space-y-4">
        <template x-for="(item, index) in items" :key="item.id">
          <div @click="openLightbox(item)"
               class="break-inside-avoid bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden cursor-pointer
                      hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group relative">

            {{-- Image --}}
            <div class="relative overflow-hidden bg-slate-100">
              <img :src="item.image_url"
                   :alt="item.judul"
                   :class="'w-full object-cover group-hover:scale-105 transition-transform duration-500'"
                   :style="'min-height: ' + (200 + (index % 3) * 60) + 'px'"
                   loading="lazy" />

              {{-- Overlay on hover --}}
              <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors duration-300 flex items-center justify-center">
                <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 drop-shadow-lg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.4-5.4M3 10a7 7 0 1 0 14 0 7 7 0 0 0-14 0Zm12 0-5 3V7l5 3Z" />
                </svg>
              </div>
            </div>

            {{-- Caption --}}
            <div class="p-3">
              <h3 class="text-sm font-semibold text-slate-800 line-clamp-1" x-text="item.judul"></h3>
              <p class="text-xs text-slate-500 mt-0.5 line-clamp-2" x-text="item.deskripsi || '—'"></p>
              <p class="text-[10px] text-slate-400 mt-1" x-text="$formatDate(item.tanggal)"></p>
            </div>
          </div>
        </template>
      </div>

      {{-- Pagination --}}
      <div x-show="meta.last_page > 1" class="mt-8 flex items-center justify-center gap-2">
        <button @click="load(meta.current_page - 1)" :disabled="meta.current_page <= 1"
                class="px-3 py-1.5 rounded-lg text-sm border border-slate-200 hover:bg-slate-50 disabled:opacity-30 disabled:cursor-not-allowed">
          Sebelumnya
        </button>
        <span class="text-sm text-slate-500" x-text="`${meta.current_page} / ${meta.last_page}`"></span>
        <button @click="load(meta.current_page + 1)" :disabled="meta.current_page >= meta.last_page"
                class="px-3 py-1.5 rounded-lg text-sm border border-slate-200 hover:bg-slate-50 disabled:opacity-30 disabled:cursor-not-allowed">
          Selanjutnya
        </button>
      </div>
    </div>
  </template>

  {{-- Lightbox Modal --}}
  <div x-show="lightboxOpen"
       x-cloak
       @keydown.escape.window="closeLightbox()"
       class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
       @click.self="closeLightbox()"
       x-transition.opacity.duration.300ms>
    <template x-if="lightboxItem">
      <div class="relative max-w-4xl w-full max-h-[90vh] flex flex-col bg-white rounded-2xl overflow-hidden shadow-2xl"
           @click.away="closeLightbox()">

        {{-- Close button --}}
        <button type="button" @click="closeLightbox()"
                class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-black/40 text-white flex items-center justify-center hover:bg-black/60 transition-colors">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </button>

        {{-- Image --}}
        <div class="flex-1 bg-slate-900 flex items-center justify-center min-h-[300px] max-h-[70vh]">
          <img :src="lightboxItem.image_url"
               :alt="lightboxItem.judul"
               class="w-full h-full object-contain" />
        </div>

        {{-- Info bar --}}
        <div class="p-4 bg-white">
          <h3 class="text-base font-semibold text-slate-800" x-text="lightboxItem.judul"></h3>
          <p class="text-sm text-slate-500 mt-1" x-text="lightboxItem.deskripsi || '—'"></p>
          <p class="text-xs text-slate-400 mt-1" x-text="lightboxItem.tanggal ? 'Diambil: ' + $formatDate(lightboxItem.tanggal) : ''"></p>
        </div>
      </div>
    </template>
  </div>

</div>
@endsection