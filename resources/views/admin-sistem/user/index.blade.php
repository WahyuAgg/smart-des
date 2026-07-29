@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola pengguna dan hak akses sistem')

@section('content')
<div x-data="userCrud" class="max-w-7xl mx-auto space-y-5">
  @include('components.alert')

  {{-- Toolbar --}}
  <x-master-data-toolbar
    title="User"
    description="Tambah, ubah, cari, dan hapus pengguna sistem."
    searchPlaceholder="Cari nama atau email..."
    buttonLabel="Tambah User" />

  {{-- Filter Role --}}
  <div class="flex flex-wrap items-center gap-3">
    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Filter Role:</label>
    <template x-if="roles.length > 0">
      <div class="flex flex-wrap gap-2">
        <button type="button" @click="roleFilter = ''; load(1)"
                class="px-3 py-1.5 rounded-lg text-xs font-medium transition border"
                :class="!roleFilter ? 'bg-accent text-white border-accent' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'">
          Semua
        </button>
        <template x-for="r in roles" :key="r.name">
          <button type="button" @click="roleFilter = r.name; load(1)"
                  class="px-3 py-1.5 rounded-lg text-xs font-medium transition border"
                  :class="roleFilter === r.name ? 'bg-accent text-white border-accent' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'"
                  x-text="r.name.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase())">
          </button>
        </template>
      </div>
    </template>
  </div>

  {{-- Table --}}
  <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
            <th class="px-4 py-3">#</th>
            <th class="px-4 py-3">Nama</th>
            <th class="px-4 py-3">Email</th>
            <th class="px-4 py-3">Role</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <template x-if="!loading && items.length === 0">
            <tr>
              <td colspan="6" class="px-4 py-10 text-center text-slate-400">Belum ada user.</td>
            </tr>
          </template>
          <template x-for="(item, index) in items" :key="item.id">
            <tr class="hover:bg-slate-50" :class="isSelf(item.id) ? 'bg-accent/5' : ''">
              <td class="px-4 py-3 text-slate-400 text-xs" x-text="((meta.current_page - 1) * 10) + index + 1"></td>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2.5">
                  <div class="w-8 h-8 rounded-full bg-accent/10 text-accent flex items-center justify-center text-xs font-bold uppercase" x-text="item.name.charAt(0)"></div>
                  <div>
                    <span class="font-medium text-slate-800" x-text="item.name"></span>
                    <span x-show="isSelf(item.id)" class="ml-1.5 inline-flex px-1.5 py-0.5 rounded text-[10px] font-semibold bg-accent/10 text-accent">Saya</span>
                  </div>
                </div>
              </td>
              <td class="px-4 py-3 text-slate-600" x-text="item.email"></td>
              <td class="px-4 py-3">
                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium"
                      :class="{
                        'bg-purple-50 text-purple-700': item.role_name === 'admin',
                        'bg-blue-50 text-blue-700': item.role_name === 'petugas',
                        'bg-amber-50 text-amber-700': item.role_name === 'kepala_desa',
                        'bg-slate-100 text-slate-600': !item.role_name
                      }"
                      x-text="item.role_name ? item.role_name.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase()) : '—'"></span>
              </td>
              <td class="px-4 py-3">
                <button type="button" @click="toggleActive(item)"
                        :disabled="saving || isSelf(item.id)"
                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium transition border"
                        :class="item.is_active
                          ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100'
                          : 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100'"
                        :title="isSelf(item.id) ? 'Tidak dapat mengubah status sendiri' : (item.is_active ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan')">
                  <span class="w-1.5 h-1.5 rounded-full" :class="item.is_active ? 'bg-emerald-500' : 'bg-red-500'"></span>
                  <span x-text="item.is_active ? 'Aktif' : 'Nonaktif'"></span>
                </button>
              </td>
              <td class="px-4 py-3">
                <div class="flex items-center justify-end gap-3">
                  <button type="button" @click="openEdit(item)" class="text-slate-400 hover:text-accent" title="Edit">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z" />
                    </svg>
                  </button>
                  <button type="button" @click="openDelete(item)"
                          :disabled="isSelf(item.id)"
                          class="text-slate-400 hover:text-red-600 disabled:opacity-30 disabled:cursor-not-allowed"
                          :title="isSelf(item.id) ? 'Tidak dapat menghapus akun sendiri' : 'Hapus'">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0-.8 13.2A2 2 0 0 1 16.2 21H7.8a2 2 0 0 1-2-1.8L5 6" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </template>
          <template x-if="loading">
            <tr>
              <td colspan="6" class="px-4 py-10 text-center text-slate-400">Memuat data...</td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    @include('components.pagination')
  </div>

  {{-- Modal Form --}}
  <x-modal max-width="max-w-2xl">
    <x-slot:title>
      <span x-text="editingId ? 'Edit User' : 'Tambah User'"></span>
    </x-slot:title>
    <form @submit.prevent="save()" class="space-y-6">
      @include('admin-sistem.user.partials.form')
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

  {{-- Confirm Delete --}}
  <x-confirm-dialog title="Hapus user?" confirm="remove()">
    User <strong x-text="deletingItem?.name"></strong> (<span x-text="deletingItem?.email"></span>) akan dihapus permanen.
  </x-confirm-dialog>
</div>
@endsection