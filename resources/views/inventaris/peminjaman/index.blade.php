@extends('layouts.app')

@section('title', 'Peminjaman Barang')
@section('page-title', 'Peminjaman Barang')
@section('page-subtitle', 'Kelola peminjaman barang inventaris desa.')

@section('content')
  <div x-data="peminjamanCrud" class="max-w-7xl mx-auto space-y-5">
    @include('components.alert')

    <x-master-data-toolbar
      title="Peminjaman"
      description="Catat, pantau, dan kelola peminjaman barang inventaris."
      searchPlaceholder="Cari nama peminjam atau nomor..."
      buttonLabel="Tambah Peminjaman" />

    {{-- Filter Status --}}
    <div class="flex flex-wrap gap-2">
      <button type="button" @click="filterStatus = ''; load(1)"
        class="px-3 py-1.5 rounded-lg text-xs font-medium transition"
        :class="!filterStatus ? 'bg-accent text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">Semua</button>
      <button type="button" @click="filterStatus = 'dipinjam'; load(1)"
        class="px-3 py-1.5 rounded-lg text-xs font-medium transition"
        :class="filterStatus === 'dipinjam' ? 'bg-accent text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">Dipinjam</button>
      <button type="button" @click="filterStatus = 'dikembalikan'; load(1)"
        class="px-3 py-1.5 rounded-lg text-xs font-medium transition"
        :class="filterStatus === 'dikembalikan' ? 'bg-accent text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">Dikembalikan</button>
      <button type="button" @click="filterStatus = 'dibatalkan'; load(1)"
        class="px-3 py-1.5 rounded-lg text-xs font-medium transition"
        :class="filterStatus === 'dibatalkan' ? 'bg-accent text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">Dibatalkan</button>
    </div>

    @include('inventaris.peminjaman.partials.table')

    {{-- Modal Form Tambah/Edit --}}
    <x-modal max-width="max-w-3xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Peminjaman' : 'Tambah Peminjaman'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-6">
        @include('inventaris.peminjaman.partials.form')
      </form>

      <x-slot:footer>
        <button type="button" @click="showModal = false"
          class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">Batal</button>
        <button type="button" @click="save()" :disabled="saving"
          class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover disabled:opacity-40">
          <span x-show="!saving" x-text="editingId ? 'Simpan Perubahan' : 'Simpan'"></span>
          <span x-show="saving">Menyimpan...</span>
        </button>
      </x-slot:footer>
    </x-modal>

    {{-- Konfirmasi Hapus --}}
    <x-confirm-dialog title="Hapus peminjaman?" confirm="remove()">
      Data peminjaman oleh <strong x-text="deletingItem?.nama_peminjam"></strong> akan dihapus permanen.
    </x-confirm-dialog>

    {{-- Konfirmasi Batalkan --}}
    <x-confirm-dialog title="Batalkan peminjaman?" confirm="batalkan()" :danger="false">
      Peminjaman oleh <strong x-text="batalItem?.nama_peminjam"></strong> akan dibatalkan. Stok barang akan dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection