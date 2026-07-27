@extends('layouts.app')

@section('title', 'Mutasi / Buku Besar')
@section('page-title', 'Mutasi / Buku Besar')
@section('page-subtitle', 'Riwayat mutasi stok barang inventaris desa.')

@section('content')
  <div x-data="mutasiCrud" class="max-w-7xl mx-auto space-y-5">
    @include('components.alert')

    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
      <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-accent">Inventaris</p>
        <h1 class="text-2xl font-semibold text-slate-900 mt-1">Buku Besar Mutasi</h1>
        <p class="text-sm text-slate-500 mt-1">Riwayat mutasi stok barang inventaris desa.</p>
      </div>
    </div>

    @include('inventaris.mutasi.partials.filter')
    @include('inventaris.mutasi.partials.table')

    @include('components.pagination')
  </div>
@endsection