@extends('layouts.app')

@section('title', 'Galeri Foto')
@section('page-title', 'Galeri Foto')
@section('page-subtitle', 'Dokumentasi kegiatan dan momen desa')

@section('content')
<div x-data="galeri" class="w-full mx-auto space-y-6">

  {{-- Search --}}
  <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-end justify-between">
    <div class="relative w-full sm:w-80">
      <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
      </svg>
      <input type="text" x-model="search" @input.debounce.400ms="load(1)"
             placeholder="Cari judul atau deskripsi..."
             class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent shadow-xs" />
    </div>
  </div>

  {{-- Loading --}}
  <div x-show="loading" x-cloak class="flex items-center justify-center py-24">
    <svg class="animate-spin h-10 w-10 text-accent" viewBox="0 0 24 24" fill="none">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
    </svg>
  </div>

  {{-- Error --}}
  <div x-show="!loading && error" x-cloak class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
    <p class="text-lg font-medium text-slate-600" x-text="error"></p>
    <button @click="load()" class="mt-4 px-4 py-2 rounded-xl text-sm font-medium text-white bg-accent hover:bg-accent-hover transition-colors">Coba Lagi</button>
  </div>

  {{-- Grid --}}
  <template x-if="!loading && !error">
    <div>
      {{-- Empty state --}}
      <div x-show="items.length === 0" class="text-center py-20 text-slate-400 bg-white rounded-2xl border border-slate-200/80 shadow-xs">
        <svg class="w-20 h-20 mx-auto mb-4 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
          <circle cx="8.5" cy="8.5" r="1.5" />
          <path d="m21 15-5-5L5 21" />
        </svg>
        <p class="text-base font-medium text-slate-600">Belum ada foto galeri.</p>
        <p class="text-sm mt-1">Foto-foto dokumentasi desa akan tampil di sini.</p>
      </div>

      {{-- Photo Grid -- Modern & Dynamic Masonry --}}
      <div x-show="items.length > 0"
           class="columns-1 sm:columns-2 lg:columns-3 gap-5 space-y-5">
        <template x-for="(item, index) in items" :key="item.id">
          <div @click="openLightbox(item)"
               class="break-inside-avoid rounded-2xl shadow-md border border-slate-800/80 bg-slate-800/20 overflow-hidden cursor-pointer
                      hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group relative">

            {{-- Image Container (Larger Photos) --}}
            <div class="relative overflow-hidden bg-slate-500">
              <img :src="item.image_url"
                   :alt="item.judul"
                   class="w-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                   :style="'min-height: ' + (320 + (index % 3) * 70) + 'px'"
                   loading="lazy" />

              {{-- Dark Hover Overlay --}}
              <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white shadow-lg transform scale-75 group-hover:scale-100 transition-transform duration-300">
                  <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
                  </svg>
                </div>
              </div>
            </div>

            {{-- Caption Bar: Dark Background, Single Line (Title + Date), End-to-End, Justify Between --}}
            <div class="w-full px-3.5 py-2.5 bg-slate-800/30 border-t border-slate-800/60 flex items-center justify-between gap-2">
              <h3 class="text-xs font-semibold text-slate-100 truncate flex-1 min-w-0" :title="item.judul" x-text="item.judul"></h3>
              <span class="text-[11px] font-normal text-slate-400 shrink-0 whitespace-nowrap" x-text="$formatDate(item.tanggal)"></span>
            </div>
          </div>
        </template>
      </div>

      {{-- Pagination --}}
      <div x-show="meta.last_page > 1" class="mt-10 flex items-center justify-center gap-2">
        <button @click="load(meta.current_page - 1)" :disabled="meta.current_page <= 1"
                class="px-4 py-2 rounded-xl text-sm font-medium border border-slate-200 bg-white hover:bg-slate-50 disabled:opacity-30 disabled:cursor-not-allowed shadow-xs transition-colors">
          Sebelumnya
        </button>
        <span class="text-sm font-medium text-slate-600 px-3 py-1 bg-white rounded-lg border border-slate-200/80 shadow-xs" x-text="`${meta.current_page} / ${meta.last_page}`"></span>
        <button @click="load(meta.current_page + 1)" :disabled="meta.current_page >= meta.last_page"
                class="px-4 py-2 rounded-xl text-sm font-medium border border-slate-200 bg-white hover:bg-slate-50 disabled:opacity-30 disabled:cursor-not-allowed shadow-xs transition-colors">
          Selanjutnya
        </button>
      </div>
    </div>
  </template>

  {{-- Lightbox Modal --}}
  <div x-show="lightboxOpen"
       x-cloak
       @keydown.escape.window="closeLightbox()"
       class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-md p-4"
       @click.self="closeLightbox()"
       x-transition.opacity.duration.300ms>
    <template x-if="lightboxItem">
      <div class="relative max-w-5xl w-full max-h-[92vh] flex flex-col bg-slate-950 rounded-2xl overflow-hidden shadow-2xl border border-slate-800"
           @click.away="closeLightbox()">

        {{-- Close button --}}
        <button type="button" @click="closeLightbox()"
                class="absolute top-3.5 right-3.5 z-10 w-9 h-9 rounded-full bg-black/60 backdrop-blur-md text-white flex items-center justify-center hover:bg-black/90 transition-colors border border-white/10 shadow-lg">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </button>

        {{-- Image --}}
        <div class="flex-1 bg-black flex items-center justify-center min-h-[350px] max-h-[75vh] p-2">
          <img :src="lightboxItem.image_url"
               :alt="lightboxItem.judul"
               class="w-full h-full object-contain max-h-[72vh] rounded-lg" />
        </div>

        {{-- Info bar --}}
        <div class="px-5 py-3.5 bg-slate-900 border-t border-slate-800 flex items-center justify-between gap-4">
          <div class="min-w-0 flex-1">
            <h3 class="text-sm font-semibold text-slate-100 truncate" x-text="lightboxItem.judul"></h3>
            <template x-if="lightboxItem.deskripsi">
              <p class="text-xs text-slate-400 mt-0.5 line-clamp-1" x-text="lightboxItem.deskripsi"></p>
            </template>
          </div>
          <span class="text-xs font-medium text-slate-400 shrink-0 whitespace-nowrap bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700/60"
                x-text="lightboxItem.tanggal ? $formatDate(lightboxItem.tanggal) : ''"></span>
        </div>
      </div>
    </template>
  </div>

</div>
@endsection