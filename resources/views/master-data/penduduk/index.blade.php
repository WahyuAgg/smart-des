@extends('layouts.app')

@section('title', 'Master Penduduk')
@section('page-title', 'Master Penduduk')
@section('page-subtitle', 'Kelola data penduduk desa, lengkap dengan pencarian dan CRUD.')

@section('content')
  <div x-data="pendudukCrud" class="max-w-7xl mx-auto">
    @include('components.alert')

    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between mb-5">
      <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-accent">Master Data</p>
        <h1 class="text-2xl font-semibold text-slate-900 mt-1">Penduduk</h1>
        <p class="text-sm text-slate-500 mt-1">Tambah, ubah, cari, dan hapus data penduduk dari satu halaman.</p>
      </div>

      <div class="flex flex-col sm:flex-row gap-3 sm:items-center w-full lg:w-auto">
        <div class="relative w-full sm:w-80">
          <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="m21 21-4.3-4.3M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
          </svg>
          <input type="text" x-model="search" @input.debounce.400ms="load(1)" placeholder="Cari NIK, nama, email, atau nomor HP..."
            class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
        </div>

        <button type="button" @click="openCreate()"
          class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover shrink-0">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
          </svg>
          Tambah Penduduk
        </button>
      </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
              <th class="px-4 py-3">NIK</th>
              <th class="px-4 py-3">Nama</th>
              <th class="px-4 py-3">JK</th>
              <th class="px-4 py-3">TTL</th>
              <th class="px-4 py-3">Status</th>
              <th class="px-4 py-3">Kontak</th>
              <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-slate-100">
            <template x-if="!loading && items.length === 0">
              <tr>
                <td colspan="7" class="px-4 py-10 text-center text-slate-400">Belum ada data penduduk.</td>
              </tr>
            </template>

            <template x-for="item in items" :key="item.id">
              <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-mono text-xs text-slate-700" x-text="item.nik"></td>
                <td class="px-4 py-3">
                  <div class="font-medium text-slate-800" x-text="item.nama_lengkap"></div>
                  <div class="text-xs text-slate-400" x-text="item.email || '—'"></div>
                </td>
                <td class="px-4 py-3 text-slate-600" x-text="genderLabel(item.jenis_kelamin)"></td>
                <td class="px-4 py-3 text-slate-600">
                  <div x-text="item.tempat_lahir || '—'"></div>
                  <div class="text-xs text-slate-400" x-text="formatDate(item.tanggal_lahir)"></div>
                </td>
                <td class="px-4 py-3">
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" :class="statusBadge(item.status_hidup)"
                    x-text="statusLabel(item.status_hidup)"></span>
                </td>
                <td class="px-4 py-3 text-slate-600">
                  <div x-text="item.no_hp || '—'"></div>
                  <div class="text-xs text-slate-400" x-text="item.status_perkawinan || '—'"></div>
                </td>
                <td class="px-4 py-3">
                  <div class="flex items-center justify-end gap-3">
                    <button type="button" @click="openEdit(item)" class="text-slate-400 hover:text-accent" title="Edit">
                      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z" />
                      </svg>
                    </button>
                    <button type="button" @click="openDelete(item)" class="text-slate-400 hover:text-red-600" title="Hapus">
                      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0-.8 13.2A2 2 0 0 1 16.2 21H7.8a2 2 0 0 1-2-1.8L5 6" />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            </template>

            <template x-if="loading">
              <tr>
                <td colspan="7" class="px-4 py-10 text-center text-slate-400">Memuat data...</td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>

      <div x-show="meta.last_page > 1"
        class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between px-4 py-3 border-t border-slate-200 text-xs text-slate-500">
        <span>Halaman <span x-text="meta.current_page"></span> dari <span x-text="meta.last_page"></span> · <span x-text="meta.total"></span> data</span>
        <div class="flex gap-2">
          <button type="button" @click="load(meta.current_page - 1)" :disabled="meta.current_page <= 1"
            class="px-3 py-1.5 rounded-md border border-slate-300 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed">Sebelumnya</button>
          <button type="button" @click="load(meta.current_page + 1)" :disabled="meta.current_page >= meta.last_page"
            class="px-3 py-1.5 rounded-md border border-slate-300 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed">Berikutnya</button>
        </div>
      </div>
    </div>

    <x-modal max-width="max-w-5xl">
      <x-slot:title>
        <span x-text="editingId ? 'Edit Penduduk' : 'Tambah Penduduk'"></span>
      </x-slot:title>

      <form @submit.prevent="save()" class="space-y-6">
        <section class="space-y-4">
          <div>
            <h4 class="text-sm font-semibold text-slate-800">Identitas</h4>
            <p class="text-xs text-slate-400">Data pokok untuk identifikasi penduduk.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form.input label="NIK" model="form.nik" placeholder="330602xxxxxxxxxx" required />
            <x-form.input label="Nama Lengkap" model="form.nama_lengkap" placeholder="Nama sesuai identitas" required />
            <x-form.select label="Jenis Kelamin" model="form.jenis_kelamin" :nullable="false" :options="[
              ['value' => 'Laki-laki', 'label' => 'Laki-laki'],
              ['value' => 'Perempuan', 'label' => 'Perempuan'],
            ]" required />
            <x-form.input label="Tempat Lahir" model="form.tempat_lahir" placeholder="Contoh: Purworejo" />
            <x-form.input type="date" label="Tanggal Lahir" model="form.tanggal_lahir" />
            <x-form.select label="Agama" model="form.agama" :nullable="false" :options="[
              ['value' => 'ISLAM', 'label' => 'Islam'],
              ['value' => 'KRISTEN', 'label' => 'Kristen'],
              ['value' => 'KATOLIK', 'label' => 'Katolik'],
              ['value' => 'HINDU', 'label' => 'Hindu'],
              ['value' => 'BUDHA', 'label' => 'Budha'],
              ['value' => 'KONGHUCU', 'label' => 'Konghucu'],
            ]" />
          </div>
        </section>

        <section class="space-y-4">
          <div>
            <h4 class="text-sm font-semibold text-slate-800">Keluarga & Pendidikan</h4>
            <p class="text-xs text-slate-400">Relasi keluarga dan pendidikan formal.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-form.input label="Nama Ayah Kandung" model="form.nama_ayah_kandung" placeholder="Nama ayah" />
            <x-form.input label="Nama Ibu Kandung" model="form.nama_ibu_kandung" placeholder="Nama ibu" />
            <x-form.select label="Status Perkawinan" model="form.status_perkawinan" :options="[
              ['value' => 'Belum Kawin', 'label' => 'Belum Kawin'],
              ['value' => 'Kawin Tercatat', 'label' => 'Kawin Tercatat'],
              ['value' => 'Kawin Belum Tercatat', 'label' => 'Kawin Belum Tercatat'],
              ['value' => 'Cerai Hidup', 'label' => 'Cerai Hidup'],
              ['value' => 'Cerai Mati', 'label' => 'Cerai Mati'],
            ]" />
            <x-form.input label="Pekerjaan" model="form.pekerjaan" placeholder="Contoh: Petani/Pekebun" />
          </div>
        </section>

        <section class="space-y-4">
          <div>
            <h4 class="text-sm font-semibold text-slate-800">Kontak & Status</h4>
            <p class="text-xs text-slate-400">Informasi kontak dan status kehidupan penduduk.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-form.input label="Kewarganegaraan" model="form.kewarganegaraan" placeholder="Indonesia" />
            <x-form.select label="Golongan Darah" model="form.golongan_darah" :options="[
              ['value' => 'A', 'label' => 'A'],
              ['value' => 'B', 'label' => 'B'],
              ['value' => 'AB', 'label' => 'AB'],
              ['value' => 'O', 'label' => 'O'],
              ['value' => '-', 'label' => '-'],
            ]" />
            <x-form.input label="No. HP" model="form.no_hp" placeholder="08xxxxxxxxxx" />
            <x-form.input type="email" label="Email" model="form.email" placeholder="nama@email.com" />
            <x-form.select label="Status Hidup" model="form.status_hidup" :nullable="false" :options="[
              ['value' => 'HIDUP', 'label' => 'Hidup'],
              ['value' => 'MENINGGAL', 'label' => 'Meninggal'],
            ]" hint="Nilai ini akan menentukan apakah tanggal meninggal perlu diisi." />
            <div x-show="form.status_hidup === 'MENINGGAL'">
              <x-form.input type="date" label="Tanggal Meninggal" model="form.tanggal_meninggal" />
            </div>
          </div>
        </section>

        <section class="space-y-4">
          <div class="flex items-center justify-between gap-3">
            <div>
              <h4 class="text-sm font-semibold text-slate-800">Alamat</h4>
              <p class="text-xs text-slate-400">Lengkapi jika data alamat akan disimpan sekaligus.</p>
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-slate-600 shrink-0">
              <input type="checkbox" x-model="form.alamat.is_utama" class="rounded border-slate-300 text-accent focus:ring-accent">
              Alamat utama
            </label>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form.input label="Label Alamat" model="form.alamat.label_alamat" placeholder="Rumah / Kantor" />
            <x-form.input label="Negara" model="form.alamat.negara" placeholder="Indonesia" />
            <x-form.textarea class="md:col-span-2" label="Alamat Lengkap" model="form.alamat.alamat_lengkap" rows="3"
              placeholder="Alamat lengkap sesuai kebutuhan surat" />
            <x-form.input label="Jalan" model="form.alamat.jalan" placeholder="Nama jalan" />
            <x-form.input label="Gedung / Perumahan" model="form.alamat.gedung_perumahan" placeholder="Nama komplek" />
            <div class="grid grid-cols-3 gap-4 md:col-span-2 lg:col-span-1">
              <x-form.input label="No. Rumah" model="form.alamat.nomor_rumah" placeholder="12" />
              <x-form.input label="Blok" model="form.alamat.blok" placeholder="A" />
              <x-form.input label="Lantai" model="form.alamat.no_lantai" placeholder="1" />
            </div>
            <div class="grid grid-cols-2 gap-4 md:col-span-2 lg:col-span-1">
              <x-form.input label="Unit" model="form.alamat.no_unit" placeholder="3" />
              <x-form.input label="Kode Pos" model="form.alamat.kode_pos" placeholder="54172" />
            </div>
            <div class="grid grid-cols-2 gap-4 md:col-span-2 lg:col-span-1">
              <x-form.input label="RT" model="form.alamat.rt" placeholder="001" />
              <x-form.input label="RW" model="form.alamat.rw" placeholder="001" />
            </div>
            <x-form.input label="Dusun" model="form.alamat.dusun" placeholder="Nama dusun" />
            <x-form.input label="Desa" model="form.alamat.desa" placeholder="Nama desa" />
            <x-form.input label="Provinsi" model="form.alamat.provinsi" placeholder="Nama provinsi" />
            <x-form.input label="Kecamatan" model="form.alamat.kecamatan" placeholder="Nama kecamatan" />
            <x-form.input label="Kabupaten" model="form.alamat.kabupaten" placeholder="Nama kabupaten" />
            <x-form.input label="Patokan" model="form.alamat.patokan" placeholder="Dekat masjid / kantor desa" />
            <x-form.input label="Latitude" model="form.alamat.latitude" placeholder="-7.7839810" />
            <x-form.input label="Longitude" model="form.alamat.longitude" placeholder="109.9614240" />
          </div>
        </section>

        <section class="space-y-4">
          <div>
            <h4 class="text-sm font-semibold text-slate-800">Lookup Referensi</h4>
            <p class="text-xs text-slate-400">Pilih KK dan pendidikan dengan pencarian langsung.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative" @click.away="kkOpen = false">
              <label class="block text-sm font-medium text-slate-700 mb-1">ID KK</label>
              <input type="hidden" x-model="form.kk_id">
              <input
                type="text"
                x-model="kkSearch"
                @focus="kkOpen = true"
                @input.debounce.300ms="searchKk()"
                placeholder="Cari no_kk"
                autocomplete="off"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
              >

              <div x-show="kkOpen" x-transition class="absolute z-30 mt-1 w-full rounded-lg border border-slate-200 bg-white shadow-lg overflow-hidden">
                <template x-if="kkLoading">
                  <div class="px-3 py-2 text-sm text-slate-400">Memuat data KK...</div>
                </template>

                <template x-if="!kkLoading && visibleKkOptions.length === 0">
                  <div class="px-3 py-2 text-sm text-slate-400">Tidak ada KK yang cocok.</div>
                </template>

                <template x-for="option in visibleKkOptions" :key="option.id">
                  <button type="button" @click="selectKk(option)" class="w-full px-3 py-2 text-left hover:bg-slate-50 border-t border-slate-100 first:border-t-0">
                    <div class="text-sm font-medium text-slate-800" x-text="option.no_kk"></div>
                    <div class="text-xs text-slate-400" x-text="'ID: ' + option.id"></div>
                  </button>
                </template>
              </div>
            </div>

            <div class="relative" @click.away="pendidikanOpen = false">
              <label class="block text-sm font-medium text-slate-700 mb-1">ID Pendidikan</label>
              <input type="hidden" x-model="form.pendidikan_id">
              <input
                type="text"
                x-model="pendidikanSearch"
                @focus="searchPendidikan()"
                @input.debounce.300ms="searchPendidikan()"
                placeholder="Cari tingkat pendidikan"
                autocomplete="off"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"
              >

              <div x-show="pendidikanOpen" x-transition class="absolute z-30 mt-1 w-full rounded-lg border border-slate-200 bg-white shadow-lg overflow-hidden">
                <template x-if="pendidikanLoading">
                  <div class="px-3 py-2 text-sm text-slate-400">Memuat data pendidikan...</div>
                </template>

                <template x-if="!pendidikanLoading && visiblePendidikanOptions.length === 0">
                  <div class="px-3 py-2 text-sm text-slate-400">Tidak ada pendidikan yang cocok.</div>
                </template>

                <template x-for="option in visiblePendidikanOptions" :key="option.id">
                  <button type="button" @click="selectPendidikan(option)" class="w-full px-3 py-2 text-left hover:bg-slate-50 border-t border-slate-100 first:border-t-0">
                    <div class="text-sm font-medium text-slate-800" x-text="option.tingkat_pendidikan"></div>
                    <div class="text-xs text-slate-400" x-text="'ID: ' + option.id"></div>
                  </button>
                </template>
              </div>
            </div>
          </div>
        </section>
      </form>

      <x-slot:footer>
        <button type="button" @click="showModal = false"
          class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">
          Batal
        </button>
        <button type="button" @click="save()" :disabled="saving"
          class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover disabled:opacity-40">
          <span x-show="!saving" x-text="editingId ? 'Simpan Perubahan' : 'Simpan'"></span>
          <span x-show="saving">Menyimpan...</span>
        </button>
      </x-slot:footer>
    </x-modal>

    <x-confirm-dialog title="Hapus penduduk?" confirm="remove()">
      Data <strong x-text="deletingItem?.nama_lengkap"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
    </x-confirm-dialog>
  </div>
@endsection