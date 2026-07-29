@extends('layouts.app')

@section('title', 'Baca Artikel')
@section('page-title', 'Baca Artikel')
@section('page-subtitle', 'Detail bacaan edukatif')

@section('content')
<div x-data="bacaanDetail" data-id="{{ $id }}" class="max-w-4xl mx-auto space-y-6">

  {{-- Loading --}}
  <div x-show="loading" x-cloak class="flex items-center justify-center py-24">
    <svg class="animate-spin h-10 w-10 text-accent" viewBox="0 0 24 24" fill="none">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
    </svg>
  </div>

  {{-- Error --}}
  <div x-show="!loading && error" x-cloak class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <p class="text-lg font-medium text-slate-600" x-text="error"></p>
    <a href="{{ route('bacaan.index') }}" class="mt-4 inline-block px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover">Kembali</a>
  </div>

  {{-- Detail --}}
  <template x-if="!loading && !error && item">
    <div class="space-y-6">

      {{-- Back --}}
      <a href="{{ route('bacaan.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-accent">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7" />
        </svg>
        Kembali ke daftar
      </a>

      {{-- Header --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <template x-if="item.thumbnail_url">
          <img :src="item.thumbnail_url" :alt="item.judul" class="w-full h-64 object-cover" />
        </template>
        <div class="p-6">
          <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
            <span class="px-2 py-0.5 rounded-full bg-accent-light text-accent-hover font-medium" x-text="item.tahun || '-'"></span>
            <span x-text="item.nama_penulis"></span>
            <template x-if="item.jumlah_halaman">
              <span x-text="item.jumlah_halaman + ' halaman'"></span>
            </template>
          </div>
          <h1 class="text-2xl font-bold text-slate-800 leading-tight" x-text="item.judul"></h1>
          <p class="text-sm text-slate-500 mt-3 leading-relaxed" x-text="item.ringkasan"></p>
        </div>
      </div>

      {{-- PDF Viewer --}}
      <template x-if="item.pdf_url">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
          <div class="flex items-center justify-between px-4 py-3 bg-slate-50 border-b border-slate-200">
            <span class="text-sm font-medium text-slate-700">Dokumen</span>
            <a :href="item.pdf_url" target="_blank" rel="noopener"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-accent hover:bg-accent-light border border-accent/20">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 19h16" />
              </svg>
              Unduh PDF
            </a>
          </div>
          <div class="bg-slate-100 p-2">
            <iframe :src="`${item.pdf_url}#toolbar=0&navpanes=0`" class="w-full h-[70vh] bg-white rounded-lg" style="border: none;" title="PDF"></iframe>
          </div>
        </div>
      </template>

    </div>
  </template>

</div>
@endsection