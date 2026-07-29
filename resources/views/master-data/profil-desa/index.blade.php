@extends('layouts.app')

@section('title', 'Profil Desa')
@section('page-title', 'Profil Desa')
@section('page-subtitle', 'Kelola profil desa, informasi wilayah, dan data kecamatan.')

@section('content')
<div x-data="profilDesa" class="max-w-5xl mx-auto space-y-5">
  @include('components.alert')

  {{-- Loading --}}
  <div x-show="loading" x-cloak class="flex items-center justify-center py-16">
    <svg class="animate-spin h-8 w-8 text-accent" viewBox="0 0 24 24" fill="none">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
    </svg>
  </div>

  {{-- Display Mode --}}
  <template x-if="!loading && !isEditing">
    <div class="space-y-5">
      {{-- If no record exists --}}
      <div x-show="!record" x-cloak
           class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
          <path d="M14 2v6h6" />
          <path d="M12 18v-6" />
          <path d="M9 15h6" />
        </svg>
        <p class="text-lg font-medium text-slate-600">Belum ada profil desa</p>
        <p class="text-sm text-slate-400 mt-1">Tambahkan informasi desa untuk memulai.</p>
        <button @click="openCreate()" class="mt-4 inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
          </svg>
          Tambah Profil Desa
        </button>
      </div>

      {{-- Record exists -- show detail --}}
      <div x-show="record" x-cloak class="space-y-5">
        @include('master-data.profil-desa.partials.show')
      </div>
    </div>
  </template>

  {{-- Edit / Create Mode --}}
  <template x-if="!loading && isEditing">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <h3 class="text-lg font-semibold text-slate-800 mb-6" x-text="record ? 'Edit Profil Desa' : 'Tambah Profil Desa'"></h3>
      <form @submit.prevent="save()" class="space-y-8">
        @include('master-data.profil-desa.partials.form')
      </form>
    </div>
  </template>
</div>
@endsection