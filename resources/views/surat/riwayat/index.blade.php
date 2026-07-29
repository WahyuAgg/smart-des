@extends('layouts.app')

@section('title', 'Riwayat Surat')
@section('page-title', 'Riwayat Surat')
@section('page-subtitle', 'Daftar seluruh pengajuan surat yang telah dibuat')

@section('content')
<div x-data="riwayatSurat" class="max-w-7xl mx-auto space-y-5">
  @include('components.alert')

  {{-- Header --}}
  <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
    <div>
      <p class="text-xs font-semibold uppercase tracking-[0.25em] text-accent">Surat</p>
      <h1 class="text-2xl font-semibold text-slate-900 mt-1">Riwayat Surat</h1>
      <p class="text-sm text-slate-500 mt-1">Daftar seluruh pengajuan surat yang telah dibuat.</p>
    </div>
  </div>

  {{-- Loading --}}
  <div x-show="loading" x-cloak class="flex items-center justify-center py-16">
    <svg class="animate-spin h-8 w-8 text-accent" viewBox="0 0 24 24" fill="none">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
    </svg>
  </div>

  {{-- Table --}}
  <div x-show="!loading" x-cloak class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
            <th class="px-4 py-3">#</th>
            <th class="px-4 py-3">Jenis Surat</th>
            <th class="px-4 py-3">Nomor Surat</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Tanggal Diajukan</th>
            <th class="px-4 py-3">Tanggal Selesai</th>
            <th class="px-4 py-3 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <template x-if="items.length === 0">
            <tr>
              <td colspan="7" class="px-4 py-10 text-center text-slate-400">Belum ada pengajuan surat.</td>
            </tr>
          </template>
          <template x-for="(item, index) in items" :key="item.id">
            <tr class="hover:bg-slate-50">
              <td class="px-4 py-3 text-slate-400 text-xs" x-text="((meta.current_page - 1) * 15) + index + 1"></td>
              <td class="px-4 py-3">
                <div>
                  <span class="font-medium text-slate-800" x-text="item.jenis_surat_nama"></span>
                  <span class="block text-[10px] text-slate-400" x-text="item.jenis_surat?.kode_jenis_surat"></span>
                </div>
              </td>
              <td class="px-4 py-3 text-slate-600 font-mono text-xs" x-text="item.nomor_surat || '—'"></td>
              <td class="px-4 py-3">
                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium border"
                      :class="statusBadgeClass(item.status)"
                      x-text="statusLabel(item.status)"></span>
              </td>
              <td class="px-4 py-3 text-slate-600 text-xs" x-text="$formatDate(item.tanggal_diajukan)"></td>
              <td class="px-4 py-3 text-slate-600 text-xs">
                <span x-text="item.tanggal_selesai ? $formatDate(item.tanggal_selesai) : '—'"></span>
              </td>
              <td class="px-4 py-3">
                <div class="flex items-center justify-end gap-2">
                  <button type="button" @click="openDetail(item)"
                          class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-accent bg-accent/5 hover:bg-accent/10 border border-accent/20 transition-colors">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm0 0h0M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z" />
                    </svg>
                    Detail
                  </button>
                  <template x-if="item.file_hasil">
                    <a :href="previewUrl(item)" target="_blank"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition-colors">
                      <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 0 0 2-2V9.414a1 1 0 0 0-.293-.707l-5.414-5.414A1 1 0 0 0 12.586 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z" />
                      </svg>
                      PDF
                    </a>
                  </template>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    @include('components.pagination')
  </div>

  {{-- Detail Modal --}}
  <div x-show="detailOpen"
       x-cloak
       @keydown.escape.window="closeDetail()"
       class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
       x-transition.opacity.duration.200ms>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-y-auto"
         @click.away="closeDetail()">

      {{-- Header --}}
      <div class="sticky top-0 bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
        <div>
          <h3 class="text-lg font-semibold text-slate-900">Detail Surat</h3>
          <p class="text-xs text-slate-500" x-text="detailItem?.jenis_surat_nama"></p>
        </div>
        <button type="button" @click="closeDetail()"
                class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center hover:bg-slate-200 transition-colors">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      {{-- Loading detail --}}
      <div x-show="detailLoading" class="flex items-center justify-center py-16">
        <svg class="animate-spin h-6 w-6 text-accent" viewBox="0 0 24 24" fill="none">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
      </div>

      {{-- Detail content --}}
      <template x-if="!detailLoading && detailItem">
        <div class="p-6 space-y-6">
          {{-- Info umum --}}
          <div>
            <h4 class="text-sm font-semibold text-slate-800 mb-3">Informasi Umum</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
              <div>
                <span class="block text-xs text-slate-400">Jenis Surat</span>
                <span class="font-medium text-slate-700" x-text="detailItem.jenis_surat_nama"></span>
              </div>
              <div>
                <span class="block text-xs text-slate-400">Kode</span>
                <span class="font-medium text-slate-700" x-text="detailItem.jenis_surat?.kode_jenis_surat"></span>
              </div>
              <div>
                <span class="block text-xs text-slate-400">Nomor Surat</span>
                <span class="font-medium text-slate-700" x-text="detailItem.nomor_surat || '—'"></span>
              </div>
              <div>
                <span class="block text-xs text-slate-400">Status</span>
                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium border mt-0.5"
                      :class="statusBadgeClass(detailItem.status)"
                      x-text="statusLabel(detailItem.status)"></span>
              </div>
              <div>
                <span class="block text-xs text-slate-400">Tanggal Diajukan</span>
                <span class="font-medium text-slate-700" x-text="$formatDate(detailItem.tanggal_diajukan)"></span>
              </div>
              <div>
                <span class="block text-xs text-slate-400">Tanggal Selesai</span>
                <span class="font-medium text-slate-700" x-text="detailItem.tanggal_selesai ? $formatDate(detailItem.tanggal_selesai) : '—'"></span>
              </div>
            </div>
          </div>

          {{-- Data Surat fields --}}
          <template x-if="detailItem.data_surat && Object.keys(detailItem.data_surat).length > 0">
            <div>
              <h4 class="text-sm font-semibold text-slate-800 mb-3">Data Surat</h4>
              <div class="grid grid-cols-2 gap-3 text-sm bg-slate-50 rounded-xl p-4">
                <template x-for="(field, key) in detailItem.data_surat" :key="key">
                  <div>
                    <span class="block text-xs text-slate-400" x-text="field.label || key"></span>
                    <span class="font-medium text-slate-700" x-text="field.value || '—'"></span>
                  </div>
                </template>
              </div>
            </div>
          </template>

          {{-- Preview button --}}
          <template x-if="detailItem.file_hasil">
            <div class="flex justify-end pt-2 border-t border-slate-100">
              <a :href="previewUrl(detailItem)" target="_blank"
                 class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 0 0 2-2V9.414a1 1 0 0 0-.293-.707l-5.414-5.414A1 1 0 0 0 12.586 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z" />
                </svg>
                Lihat / Download PDF
              </a>
            </div>
          </template>
        </div>
      </template>
    </div>
  </div>
</div>
@endsection