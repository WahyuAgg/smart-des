{{-- Display Mode: Show Profil Desa Detail --}}

{{-- Action Buttons --}}
<div class="flex justify-end gap-3">
  <button @click="openEdit()" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover">
    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
      <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z" />
    </svg>
    Edit
  </button>
  <button @click="openDelete()" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-red-600 border border-red-200 hover:bg-red-50">
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
      <template x-if="record?.logo_url">
        <img :src="record.logo_url" alt="Logo" class="w-20 h-20 rounded-xl border-4 border-white shadow-md object-cover bg-white" />
      </template>
      <template x-if="!record?.logo_url">
        <div class="w-20 h-20 rounded-xl border-4 border-white shadow-md bg-teal-100 flex items-center justify-center">
          <span class="text-2xl font-bold text-teal-600" x-text="(record?.nama || 'D').charAt(0)"></span>
        </div>
      </template>
    </div>
  </div>

  <div class="pt-12 px-6 pb-6">
    {{-- Nama & Alamat --}}
    <div class="mb-6">
      <h2 class="text-xl font-bold text-slate-800" x-text="record?.nama"></h2>
      <p class="text-sm text-slate-500 mt-1" x-text="record?.alamat"></p>
      <p class="text-xs text-slate-400 mt-0.5">
        <span x-text="record?.nama_desa"></span>,
        <span x-text="record?.nama_kecamatan"></span>,
        <span x-text="record?.nama_kabupaten"></span>,
        <span x-text="record?.nama_provinsi"></span>
      </p>
    </div>

    {{-- Detail Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
      <div>
        <span class="text-slate-400">Kode Wilayah</span>
        <p class="font-medium text-slate-700" x-text="record?.kode || '-'"></p>
      </div>
      <div>
        <span class="text-slate-400">Kode Pos</span>
        <p class="font-medium text-slate-700" x-text="record?.kode_pos || '-'"></p>
      </div>
      <div>
        <span class="text-slate-400">Telepon</span>
        <p class="font-medium text-slate-700" x-text="record?.telepon || '-'"></p>
      </div>
      <div>
        <span class="text-slate-400">Email</span>
        <p class="font-medium text-slate-700" x-text="record?.email || '-'"></p>
      </div>
      <div>
        <span class="text-slate-400">Website</span>
        <p class="font-medium text-slate-700">
          <template x-if="record?.website">
            <a :href="record.website" target="_blank" class="text-accent hover:underline" x-text="record.website"></a>
          </template>
          <template x-if="!record?.website">-</template>
        </p>
      </div>
      <div>
        <span class="text-slate-400">Peta PDF</span>
        <p class="font-medium text-slate-700">
          <template x-if="record?.peta_pdf_url">
            <a :href="record.peta_pdf_url" target="_blank" class="text-accent hover:underline">Lihat Peta</a>
          </template>
          <template x-if="!record?.peta_pdf_url">-</template>
        </p>
      </div>
    </div>
  </div>
</div>

{{-- Visi & Misi --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
  <div>
    <h3 class="text-sm font-semibold text-slate-700 mb-2">Visi</h3>
    <p class="text-sm text-slate-600" x-text="record?.visi || '-'"></p>
  </div>
  <div>
    <h3 class="text-sm font-semibold text-slate-700 mb-2">Misi</h3>
    <template x-if="record?.misi && record.misi.length > 0">
      <ol class="list-decimal list-inside space-y-1">
        <template x-for="(item, i) in record.misi" :key="i">
          <li class="text-sm text-slate-600" x-text="item"></li>
        </template>
      </ol>
    </template>
    <template x-if="!record?.misi || record.misi.length === 0">
      <p class="text-sm text-slate-400">-</p>
    </template>
  </div>
  <div>
    <h3 class="text-sm font-semibold text-slate-700 mb-2">Deskripsi</h3>
    <p class="text-sm text-slate-600" x-text="record?.deskripsi || '-'"></p>
  </div>
</div>

{{-- Profil Kecamatan --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
  <h3 class="text-sm font-semibold text-slate-700 mb-4">Profil Kecamatan</h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
    <div>
      <span class="text-slate-400">Camat</span>
      <p class="font-medium text-slate-700" x-text="record?.profil_kecamatan?.camat || '-'"></p>
    </div>
    <div>
      <span class="text-slate-400">NIP</span>
      <p class="font-medium text-slate-700" x-text="record?.profil_kecamatan?.nip || '-'"></p>
    </div>
    <div>
      <span class="text-slate-400">Telepon</span>
      <p class="font-medium text-slate-700" x-text="record?.profil_kecamatan?.telepon || '-'"></p>
    </div>
    <div>
      <span class="text-slate-400">Email</span>
      <p class="font-medium text-slate-700" x-text="record?.profil_kecamatan?.email || '-'"></p>
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