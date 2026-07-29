@extends('layouts.app')

@section('title', 'Tentang Aplikasi')
@section('page-title', 'Tentang Aplikasi')
@section('page-subtitle', 'Informasi mengenai SmartDes')

@section('content')
<div x-data="about" class="max-w-3xl mx-auto">

  {{-- Loading --}}
  <div x-show="loading" x-cloak class="flex items-center justify-center py-20">
    <svg class="animate-spin h-8 w-8 text-accent" viewBox="0 0 24 24" fill="none">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
    </svg>
  </div>

  {{-- Error --}}
  <div x-show="!loading && error" x-cloak class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <p class="text-lg text-slate-600" x-text="error"></p>
  </div>

  {{-- Content --}}
  <template x-if="!loading && !error && info">
    <div class="space-y-6">

      {{-- Header Card --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 text-center">
        <div class="w-16 h-16 rounded-full bg-accent flex items-center justify-center mx-auto mb-4">
          <span class="text-2xl font-bold text-white">SD</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-800" x-text="info.nama"></h1>
        <p class="text-sm text-slate-500 mt-1" x-text="info.tujuan"></p>
        <div class="mt-4 inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent-light text-accent-hover text-xs font-medium">
          <span x-text="'v' + info.versi"></span>
        </div>
      </div>

      {{-- Developer Info --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Pengembang</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
          <div>
            <span class="text-slate-400">Developer</span>
            <p class="font-medium text-slate-700" x-text="info.developer"></p>
          </div>
          <div>
            <span class="text-slate-400">Institusi</span>
            <p class="font-medium text-slate-700" x-text="info.institusi"></p>
          </div>
          <div>
            <span class="text-slate-400">Program</span>
            <p class="font-medium text-slate-700" x-text="info.program"></p>
          </div>
          <div>
            <span class="text-slate-400">Lisensi</span>
            <p class="font-medium text-slate-700" x-text="info.lisensi"></p>
          </div>
        </div>
      </div>

      {{-- Teknologi --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Teknologi</h2>
        <div class="flex flex-wrap gap-2">
          <template x-for="tech in info.teknologi" :key="tech">
            <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-sm font-medium" x-text="tech"></span>
          </template>
        </div>
      </div>

      {{-- Ucapan Terima Kasih --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Ucapan Terima Kasih</h2>
        <ul class="space-y-2">
          <template x-for="(item, index) in info.ucapan_terima_kasih" :key="index">
            <li class="flex items-start gap-3 text-sm text-slate-600">
              <svg class="w-4 h-4 text-accent mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
              </svg>
              <span x-text="item"></span>
            </li>
          </template>
        </ul>
      </div>

      {{-- Copyright --}}
      <div class="text-center text-xs text-slate-400 py-4" x-text="info.copyright"></div>

    </div>
  </template>

</div>
@endsection