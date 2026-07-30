@extends('layouts.app')

@section('title', 'Peta Desa')
@section('page-title', 'Peta Desa')
@section('page-subtitle', 'Lihat peta desa dalam tampilan penuh dengan zoom dan rotasi')

@section('content')
  <div x-data="petaDesa" class="mx-0 space-y-0">

    {{-- Loading --}}
    <div x-show="loading" x-cloak class="flex items-center justify-center py-24">
      <svg class="animate-spin h-10 w-10 text-accent" viewBox="0 0 24 24" fill="none">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
      </svg>
    </div>

    {{-- Error / No PDF --}}
    <div x-show="!loading && error" x-cloak
      class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center max-w-7xl mx-auto mt-6">
      <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
        <path d="M14 2v6h6" />
        <path d="M12 18v-6" />
        <path d="M9 15h6" />
      </svg>
      <p class="text-lg font-medium text-slate-600" x-text="error"></p>
      <button @click="loadPeta()"
        class="mt-4 px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover">
        Coba Lagi
      </button>
    </div>

    {{-- PDF Viewer --}}
    <template x-if="!loading && !error && pdfUrl">
      <div class="bg-white shadow-sm border border-slate-200 overflow-hidden rounded-none">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between px-4 py-3 bg-slate-50 border-b border-slate-200">
          <div class="flex items-center gap-2">
            <button @click="zoomOut()" title="Perkecil"
              class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-white border border-slate-200 text-slate-600">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
              </svg>
            </button>
            <span class="text-sm font-medium text-slate-600 w-14 text-center"
              x-text="Math.round(zoom * 100) + '%'"></span>
            <button @click="zoomIn()" title="Perbesar"
              class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-white border border-slate-200 text-slate-600">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
              </svg>
            </button>
          </div>

          <div class="flex items-center gap-2">
            <button @click="rotateRight()" title="Putar 90&deg;"
              class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-white border border-slate-200 text-slate-600">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 2h6v6M18 6 9 15M18 2l-6 6" />
              </svg>
            </button>
            <button @click="zoomReset()" title="Reset"
              class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-white border border-slate-200 text-slate-600">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M1 4v6h6M23 20v-6h-6" />
                <path d="M20.5 9.5A8.5 8.5 0 0 0 5.6 5.6L1 10m22 4-4.6 4.4A8.5 8.5 0 0 1 3.5 14.5" />
              </svg>
            </button>
            <div class="w-px h-6 bg-slate-200 mx-1"></div>
            <a :href="pdfUrl" target="_blank" rel="noopener"
              class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-accent hover:bg-accent-light border border-accent/20">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M4 19h16" />
              </svg>
              Unduh PDF
            </a>
          </div>
        </div>

        {{-- PDF Viewer — full bleed --}}
        <div class="w-full bg-slate-100 min-h-screen">
          <iframe :src="`${pdfUrl}#toolbar=0&navpanes=0&scrollbar=0`"
            class="w-full h-screen bg-white transition-transform duration-200"
            :style="`transform: scale(${zoom}) rotate(${rotation}deg); transform-origin: center center;`"
            style="border: none;" title="Peta Desa"></iframe>
        </div>
      </div>
    </template>

  </div>
@endsection
