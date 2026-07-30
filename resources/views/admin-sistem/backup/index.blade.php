@extends('layouts.app')

@section('title', 'Backup Sistem')
@section('page-title', 'Backup Sistem')
@section('page-subtitle', 'Download salinan file storage atau database SQLite untuk backup manual')

@section('content')
<div x-data="backupPage" class="max-w-5xl mx-auto space-y-6">
  @include('components.alert')

  <div class="grid gap-4 md:grid-cols-2">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
      <div class="flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-accent/10 text-accent flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 12 4-4m-4 4-4-4M4 20h16" />
          </svg>
        </div>
        <div class="space-y-1">
          <h2 class="text-lg font-semibold text-slate-900">Backup Storage</h2>
          <p class="text-sm text-slate-500">Mengunduh seluruh isi folder storage sebagai file zip.</p>
        </div>
      </div>

      <div class="mt-6 space-y-3">
        <button type="button" @click="downloadStorageFiles()" :disabled="loading"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-accent-hover transition">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 12 4-4m-4 4-4-4M4 20h16" />
          </svg>
          <span x-show="!loading">Download Storage Backup</span>
          <span x-show="loading">Mengunduh...</span>
        </button>
        <p class="text-xs text-slate-500">Endpoint: /api/backup/download-storage-files</p>
      </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
      <div class="flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4c4.4 0 8 1.1 8 2.5S16.4 9 12 9s-8-1.1-8-2.5S7.6 4 12 4Zm-8 2.5V17c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5V6.5M4 11.75c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5" />
          </svg>
        </div>
        <div class="space-y-1">
          <h2 class="text-lg font-semibold text-slate-900">Backup Database</h2>
          <p class="text-sm text-slate-500">Mengunduh file database SQLite aktif untuk restore cepat.</p>
        </div>
      </div>

      <div class="mt-6 space-y-3">
        <button type="button" @click="downloadDatabaseSqlite()" :disabled="loading"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 12 4-4m-4 4-4-4M4 20h16" />
          </svg>
          <span x-show="!loading">Download Database Backup</span>
          <span x-show="loading">Mengunduh...</span>
        </button>
        <p class="text-xs text-slate-500">Endpoint: /api/backup/download-database-sqlite</p>
      </div>
    </div>
  </div>

  <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
    <h3 class="text-sm font-semibold text-amber-900">Catatan backup</h3>
    <ul class="mt-2 space-y-1 text-sm text-amber-800/90 list-disc list-inside">
      <li>Gunakan storage backup untuk file upload, lampiran, dan aset yang disimpan di storage.</li>
      <li>Gunakan database backup untuk salinan data aplikasi sebelum restore atau migrasi.</li>
    </ul>
  </div>
</div>
@endsection