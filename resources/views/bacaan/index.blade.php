@extends('layouts.app')

@section('title', 'Bacaan Edukatif')
@section('page-title', 'Bacaan Edukatif')
@section('page-subtitle', 'Kumpulan artikel dan bacaan edukatif seputar desa')

@section('content')
<div x-data="bacaanEdukatif" class="max-w-7xl mx-auto space-y-6">

  {{-- Search & Filter --}}
  <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-end justify-between">
    <div class="relative w-full sm:w-80">
      <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
      </svg>
      <input type="text" x-model="search" @input.debounce.400ms="load(1)"
             placeholder="Cari judul atau penulis..."
             class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
    </div>
    <div class="flex items-center gap-2">
      <input type="number" x-model="tahun" @input.debounce.400ms="load(1)"
             placeholder="Tahun"
             class="w-24 px-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
    </div>
  </div>

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

  {{-- Grid --}}
  <template x-if="!loading && !error">
    <div>
      {{-- Empty state --}}
      <div x-show="items.length === 0" class="text-center py-16 text-slate-400">
        <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
          <path d="M14 2v6h6" />
        </svg>
        <p class="text-base">Belum ada artikel tersedia.</p>
      </div>

      {{-- Grid cards --}}
      <div x-show="items.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <template x-for="item in items" :key="item.id">
          <div @click="goToDetail(item.id)"
               class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden cursor-pointer hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col">

            {{-- Thumbnail --}}
            <div class="aspect-[16/10] bg-slate-100 overflow-hidden">
              <template x-if="item.thumbnail_url">
                <img :src="item.thumbnail_url" :alt="item.judul" class="w-full h-full object-cover" />
              </template>
              <template x-if="!item.thumbnail_url">
                <div class="w-full h-full flex items-center justify-center">
                  <svg class="w-12 h-12 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                    <path d="M14 2v6h6" />
                    <path d="M12 18v-6" />
                    <path d="M9 15h6" />
                  </svg>
                </div>
              </template>
            </div>

            {{-- Content --}}
            <div class="p-4 flex flex-col flex-1">
              <span class="text-xs text-accent font-medium mb-1" x-text="item.tahun || ''"></span>
              <h3 class="text-sm font-semibold text-slate-800 line-clamp-2 leading-snug" x-text="item.judul"></h3>
              <p class="text-xs text-slate-500 mt-1 line-clamp-2" x-text="item.ringkasan"></p>
              <div class="mt-auto pt-3 flex items-center justify-between text-xs text-slate-400">
                <span x-text="item.nama_penulis"></span>
                <template x-if="item.jumlah_halaman">
                  <span x-text="item.jumlah_halaman + ' hlm'"></span>
                </template>
              </div>
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

</div>
@endsection