{{-- Display Mode: Show Profil Desa Detail --}}

{{-- Action Buttons --}}
<div class="flex justify-end gap-3">
  <button @click="openEdit()" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover transition-colors">
    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
      <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z" />
    </svg>
    Edit Profil
  </button>
  <button @click="openDelete()" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-red-600 border border-red-200 hover:bg-red-50 transition-colors">
    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0-.8 13.2A2 2 0 0 1 16.2 21H7.8a2 2 0 0 1-2-1.8L5 6" />
    </svg>
    Hapus
  </button>
</div>

{{-- Info Desa Card --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
  {{-- Header with logo --}}
  <div class="relative h-32 bg-gradient-to-r from-teal-600 to-teal-400">
    <div class="absolute -bottom-10 left-6">
      <template x-if="existingLogoUrl">
        <img :src="existingLogoUrl" alt="Logo Desa" class="w-20 h-20 rounded-xl border-4 border-white shadow-md object-cover bg-white" />
      </template>
      <template x-if="!existingLogoUrl">
        <div class="w-20 h-20 rounded-xl border-4 border-white shadow-md bg-teal-100 flex items-center justify-center">
          <span class="text-2xl font-bold text-teal-600" x-text="(record?.nama || 'D').charAt(0)"></span>
        </div>
      </template>
    </div>
  </div>

  <div class="pt-12 px-6 pb-6">
    {{-- Nama & Alamat --}}
    <div class="mb-6 border-b border-slate-100 pb-5">
      <div class="flex items-center gap-3">
        <h2 class="text-xl font-bold text-slate-800" x-text="record?.nama"></h2>
        <span class="text-xs px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-700 font-medium border border-teal-200" x-text="record?.kode ? 'Kode: ' + record.kode : 'Profil Desa'"></span>
      </div>
      
      {{-- Alamat Lengkap --}}
      <template x-if="record?.alamat">
        <div class="mt-2 text-sm text-slate-600 flex items-start gap-1.5">
          <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
          </svg>
          <span class="font-medium text-slate-700" x-text="record.alamat"></span>
        </div>
      </template>

      <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6h1.5m-1.5 3h1.5m-1.5 3h1.5" />
        </svg>
        <span x-text="record?.nama_desa"></span>,
        <span x-text="record?.nama_kecamatan"></span>,
        <span x-text="record?.nama_kabupaten"></span>,
        <span x-text="record?.nama_provinsi"></span>
      </p>
    </div>

    {{-- Detail Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
      <div>
        <span class="text-xs text-slate-400 block">Kode Wilayah</span>
        <p class="font-medium text-slate-700 mt-0.5" x-text="record?.kode || '-'"></p>
      </div>
      <div>
        <span class="text-xs text-slate-400 block">Kode Pos</span>
        <p class="font-medium text-slate-700 mt-0.5" x-text="record?.kode_pos || '-'"></p>
      </div>
      <div>
        <span class="text-xs text-slate-400 block">Telepon</span>
        <p class="font-medium text-slate-700 mt-0.5" x-text="record?.telepon || '-'"></p>
      </div>
      <div>
        <span class="text-xs text-slate-400 block">Email</span>
        <p class="font-medium text-slate-700 mt-0.5" x-text="record?.email || '-'"></p>
      </div>
      <div>
        <span class="text-xs text-slate-400 block">Website</span>
        <p class="font-medium text-slate-700 mt-0.5">
          <template x-if="record?.website">
            <a :href="record.website" target="_blank" class="text-accent hover:underline inline-flex items-center gap-1" x-text="record.website">
              <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
              </svg>
            </a>
          </template>
          <template x-if="!record?.website">-</template>
        </p>
      </div>
      <div>
        <span class="text-xs text-slate-400 block">Peta PDF</span>
        <p class="font-medium text-slate-700 mt-0.5">
          <template x-if="existingPetaPdfUrl">
            <a :href="existingPetaPdfUrl" target="_blank" class="text-accent hover:underline inline-flex items-center gap-1 font-medium">
              <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
              </svg>
              Lihat File Peta PDF
            </a>
          </template>
          <template x-if="!existingPetaPdfUrl">-</template>
        </p>
      </div>
    </div>
  </div>
</div>

{{-- Wilayah Administrasi --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
  <h3 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.5-8.25 3-1.5v12l-3 1.5m-6.5-12 3-1.5v12l-3 1.5m-3.5-13.5 3.5 1.5v12l-3.5-1.5" />
    </svg>
    Wilayah Administrasi
  </h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
    <div>
      <span class="text-xs text-slate-400 block">Provinsi</span>
      <p class="font-medium text-slate-700 mt-0.5" x-text="record?.nama_provinsi || record?.provinsi?.name || '-'"></p>
    </div>
    <div>
      <span class="text-xs text-slate-400 block">Kabupaten / Kota</span>
      <p class="font-medium text-slate-700 mt-0.5" x-text="record?.nama_kabupaten || record?.kabupaten?.name || '-'"></p>
    </div>
    <div>
      <span class="text-xs text-slate-400 block">Kecamatan</span>
      <p class="font-medium text-slate-700 mt-0.5" x-text="record?.nama_kecamatan || record?.kecamatan?.name || '-'"></p>
    </div>
    <div>
      <span class="text-xs text-slate-400 block">Desa / Kelurahan</span>
      <p class="font-medium text-slate-700 mt-0.5" x-text="record?.nama_desa || record?.desa?.name || '-'"></p>
    </div>
  </div>
</div>

{{-- Visi & Misi --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-5">
  <div>
    <h3 class="text-sm font-semibold text-slate-700 mb-2">Visi</h3>
    <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-lg border border-slate-100" x-text="record?.visi || '-'"></p>
  </div>
  <div>
    <h3 class="text-sm font-semibold text-slate-700 mb-2">Misi</h3>
    <template x-if="record?.misi && record.misi.length > 0">
      <ol class="list-decimal list-inside space-y-1.5 bg-slate-50 p-4 rounded-lg border border-slate-100">
        <template x-for="(item, i) in record.misi" :key="i">
          <li class="text-sm text-slate-600 leading-relaxed" x-text="item"></li>
        </template>
      </ol>
    </template>
    <template x-if="!record?.misi || record.misi.length === 0">
      <p class="text-sm text-slate-400 bg-slate-50 p-3 rounded-lg border border-slate-100">-</p>
    </template>
  </div>
  <div>
    <h3 class="text-sm font-semibold text-slate-700 mb-2">Deskripsi</h3>
    <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-lg border border-slate-100" x-text="record?.deskripsi || '-'"></p>
  </div>
</div>

{{-- Profil Kecamatan --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
  <h3 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5" />
    </svg>
    Profil Kecamatan
  </h3>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-6">
    <div>
      <span class="text-xs text-slate-400 block">Nama Camat</span>
      <p class="font-medium text-slate-700 mt-0.5" x-text="record?.profil_kecamatan?.camat || '-'"></p>
    </div>
    <div>
      <span class="text-xs text-slate-400 block">NIP Camat</span>
      <p class="font-medium text-slate-700 mt-0.5" x-text="record?.profil_kecamatan?.nip || '-'"></p>
    </div>
    <div>
      <span class="text-xs text-slate-400 block">Telepon Kecamatan</span>
      <p class="font-medium text-slate-700 mt-0.5" x-text="record?.profil_kecamatan?.telepon || '-'"></p>
    </div>
    <div>
      <span class="text-xs text-slate-400 block">Email Kecamatan</span>
      <p class="font-medium text-slate-700 mt-0.5" x-text="record?.profil_kecamatan?.email || '-'"></p>
    </div>
  </div>


</div>

{{-- Delete Confirmation --}}
<div x-show="confirmDelete" x-cloak class="fixed inset-0 z-40 flex items-center justify-center p-4">
  <div x-show="confirmDelete" x-transition.opacity @click="confirmDelete = false" class="absolute inset-0 bg-slate-900/40"></div>
  <div x-show="confirmDelete" x-transition @click.outside="confirmDelete = false"
       class="relative bg-white rounded-xl shadow-lg w-full max-w-md p-6">
    <div class="flex items-start gap-4">
      <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
        </svg>
      </div>
      <div>
        <h3 class="text-sm font-semibold text-slate-800">Hapus profil desa?</h3>
        <p class="text-sm text-slate-500 mt-1">Semua data termasuk file yang diunggah akan dihapus permanen.</p>
      </div>
    </div>
    <div class="flex justify-end gap-3 mt-6">
      <button @click="confirmDelete = false" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">Batal</button>
      <button @click="remove()" :disabled="deleting" class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 disabled:opacity-40">
        <span x-show="!deleting">Ya, Hapus</span>
        <span x-show="deleting">Menghapus...</span>
      </button>
    </div>
  </div>
</div>
