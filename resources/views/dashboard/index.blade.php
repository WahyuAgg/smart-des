@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data kependudukan dan profil desa')

@section('content')
<div x-data="dashboard" class="-mx-6 -mt-6">
  {{-- Loading state --}}
  <div x-show="loading" x-cloak class="flex items-center justify-center py-20">
    <svg class="animate-spin h-10 w-10 text-accent" viewBox="0 0 24 24" fill="none">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
    </svg>
  </div>

  {{-- Error state --}}
  <div x-show="error" x-cloak class="flex flex-col items-center justify-center py-20 text-center">
    <svg class="w-16 h-16 text-red-300 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
    </svg>
    <p class="text-lg font-medium text-slate-700">Gagal memuat data</p>
    <p class="text-sm text-slate-500 mt-1" x-text="error"></p>
    <button @click="fetchAll()" class="mt-4 px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent-hover transition">
      Coba Lagi
    </button>
  </div>

  {{-- Content --}}
  <template x-if="!loading && !error">
    <div class="space-y-0">

      {{-- Hero / Profil Desa Banner --}}
      @include('dashboard.partials.profile-header')

      {{-- Stat Cards --}}
      @include('dashboard.partials.stat-cards')

      {{-- Charts Section --}}
      <div class="px-6 py-6 space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-5">
          @include('dashboard.partials.chart-umur')
          @include('dashboard.partials.chart-pendidikan')
          @include('dashboard.partials.chart-pekerjaan')
          @include('dashboard.partials.chart-agama')
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-5">
          @include('dashboard.partials.chart-gender')
          <div class="xl:col-span-3 grid grid-cols-1 xl:grid-cols-3 gap-5">
            @include('dashboard.partials.visi-misi')
            @include('dashboard.partials.perangkat-desa')
            @include('dashboard.partials.riwayat-surat')
          </div>
        </div>
      </div>

    </div>
  </template>

</div>
@endsection