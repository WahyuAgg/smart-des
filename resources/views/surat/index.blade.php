@extends('layouts.app')

@section('title', 'Pengajuan Surat')
@section('page-title', 'Pengajuan Surat')
@section('page-subtitle', 'Ajukan surat keterangan dalam empat langkah singkat')

@section('content')
<div x-data="suratWizard" class="max-w-3xl mx-auto">

  @include('components.step-indicator')
  @include('components.alert')

  <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 relative min-h-[320px]">

    {{-- loading overlay --}}
    <div x-show="loading" x-cloak
         class="absolute inset-0 bg-white/70 flex items-center justify-center rounded-xl z-10">
      <svg class="w-8 h-8 animate-spin text-accent" viewBox="0 0 24 24" fill="none">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z"/>
      </svg>
    </div>

    @include('surat.steps.pilih-jenis-surat')
    @include('surat.steps.isi-nik')
    @include('surat.steps.isi-data-manual')
    @include('surat.steps.preview-download')

  </div>
</div>
@endsection

<!-- @push('scripts')
  <script>
    window.API_BASE_URL = "{{ rtrim(config('services.surat.base_url', env('SURAT_API_URL', url('/api'))), '/') }}";
  </script>
  @vite('resources/js/surat-wizard.js')
@endpush -->
