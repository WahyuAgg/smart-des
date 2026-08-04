<x-modal show="detailShow" max-width="max-w-3xl">
  <x-slot:title>
    <span>Detail Penduduk</span>
  </x-slot:title>

  <div x-show="detailLoading" class="py-12 text-center text-slate-400">
    <svg class="w-8 h-8 mx-auto animate-spin text-slate-400 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    <span>Memuat detail penduduk...</span>
  </div>

  <div x-show="!detailLoading && detailItem" class="space-y-6">
    {{-- Header Profile Brief --}}
    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h4 class="text-base font-semibold text-slate-800" x-text="detailItem?.nama_lengkap || '—'"></h4>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 mt-1">
          <span>NIK: <strong class="font-mono text-slate-700" x-text="detailItem?.nik || '—'"></strong></span>
          <span x-show="detailItem?.kk?.no_kk">No. KK: <strong class="font-mono text-slate-700" x-text="detailItem?.kk?.no_kk"></strong></span>
        </div>
      </div>
      <div class="flex items-center gap-2 shrink-0">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
          :class="statusBadge(detailItem?.status_hidup)"
          x-text="statusLabel(detailItem?.status_hidup)"></span>
      </div>
    </div>

    {{-- Section 1: Identitas Diri --}}
    <div>
      <h5 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Identitas & Demografi</h5>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm bg-white p-4 border border-slate-100 rounded-lg">
        <div>
          <span class="text-xs text-slate-400 block">NIK</span>
          <span class="font-mono font-medium text-slate-800" x-text="detailItem?.nik || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Nama Lengkap</span>
          <span class="font-medium text-slate-800" x-text="detailItem?.nama_lengkap || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Jenis Kelamin</span>
          <span class="text-slate-700" x-text="genderLabel(detailItem?.jenis_kelamin)"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Tempat Lahir</span>
          <span class="text-slate-700" x-text="detailItem?.tempat_lahir || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Tanggal Lahir</span>
          <span class="text-slate-700" x-text="detailItem?.tanggal_lahir_f || (detailItem?.tanggal_lahir ? $formatDate(detailItem.tanggal_lahir) : '—')"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Tempat, Tanggal Lahir</span>
          <span class="text-slate-700" x-text="detailItem?.ttl || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Umur</span>
          <span class="text-slate-700" x-text="detailItem?.umur ? detailItem.umur + ' tahun' : '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Agama</span>
          <span class="text-slate-700" x-text="detailItem?.agama || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Pekerjaan</span>
          <span class="text-slate-700" x-text="detailItem?.pekerjaan || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Status Perkawinan</span>
          <span class="text-slate-700" x-text="detailItem?.status_perkawinan || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Kewarganegaraan</span>
          <span class="text-slate-700" x-text="detailItem?.kewarganegaraan || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Golongan Darah</span>
          <span class="text-slate-700" x-text="detailItem?.golongan_darah || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Status Hidup</span>
          <span class="text-slate-700" x-text="statusLabel(detailItem?.status_hidup)"></span>
        </div>
        <template x-if="detailItem?.tanggal_meninggal">
          <div>
            <span class="text-xs text-slate-400 block">Tanggal Meninggal</span>
            <span class="text-slate-700" x-text="$formatDate(detailItem.tanggal_meninggal)"></span>
          </div>
        </template>
      </div>
    </div>

    {{-- Section 2: Kartu Keluarga & Pendidikan --}}
    <div>
      <h5 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Keluarga & Pendidikan</h5>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm bg-white p-4 border border-slate-100 rounded-lg">
        <div>
          <span class="text-xs text-slate-400 block">Nomor KK</span>
          <span class="font-mono text-slate-800" x-text="detailItem?.kk?.no_kk || detailItem?.no_kk || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">NIK Kepala Keluarga</span>
          <span class="font-mono text-slate-800" x-text="detailItem?.kk?.nik_kepala_keluarga || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Tingkat Pendidikan</span>
          <span class="text-slate-800" x-text="detailItem?.pendidikan?.tingkat_pendidikan || detailItem?.nama_pendidikan || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Nama Ayah Kandung</span>
          <span class="text-slate-800" x-text="detailItem?.nama_ayah_kandung || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Nama Ibu Kandung</span>
          <span class="text-slate-800" x-text="detailItem?.nama_ibu_kandung || '—'"></span>
        </div>
      </div>
    </div>

    {{-- Section 3: Kontak & Alamat --}}
    <div>
      <h5 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Kontak & Alamat</h5>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm bg-white p-4 border border-slate-100 rounded-lg">
        <div>
          <span class="text-xs text-slate-400 block">No. HP</span>
          <span class="text-slate-800" x-text="detailItem?.no_hp || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Email</span>
          <span class="text-slate-800" x-text="detailItem?.email || '—'"></span>
        </div>
        <div class="sm:col-span-2">
          <span class="text-xs text-slate-400 block">Alamat Lengkap</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.alamat_formatted || detailItem?.alamat?.alamat_lengkap || '—'"></span>
        </div>
      </div>
    </div>

    {{-- Section 4: Detail Alamat --}}
    <div x-show="detailItem?.alamat">
      <h5 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Detail Alamat</h5>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm bg-white p-4 border border-slate-100 rounded-lg">
        <div>
          <span class="text-xs text-slate-400 block">Jalan</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.jalan || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Dusun</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.dusun || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">RT</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.rt || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">RW</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.rw || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Desa/Kelurahan</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.desa || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Kecamatan</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.kecamatan || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Kabupaten</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.kabupaten || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Provinsi</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.provinsi || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Kode Pos</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.kode_pos || '—'"></span>
        </div>
        <div>
          <span class="text-xs text-slate-400 block">Negara</span>
          <span class="text-slate-800" x-text="detailItem?.alamat?.negara || '—'"></span>
        </div>
        <template x-if="detailItem?.alamat?.nomor_rumah">
          <div>
            <span class="text-xs text-slate-400 block">Nomor Rumah</span>
            <span class="text-slate-800" x-text="detailItem.alamat.nomor_rumah"></span>
          </div>
        </template>
        <template x-if="detailItem?.alamat?.blok">
          <div>
            <span class="text-xs text-slate-400 block">Blok</span>
            <span class="text-slate-800" x-text="detailItem.alamat.blok"></span>
          </div>
        </template>
        <template x-if="detailItem?.alamat?.no_lantai">
          <div>
            <span class="text-xs text-slate-400 block">No. Lantai</span>
            <span class="text-slate-800" x-text="detailItem.alamat.no_lantai"></span>
          </div>
        </template>
        <template x-if="detailItem?.alamat?.no_unit">
          <div>
            <span class="text-xs text-slate-400 block">No. Unit</span>
            <span class="text-slate-800" x-text="detailItem.alamat.no_unit"></span>
          </div>
        </template>
        <template x-if="detailItem?.alamat?.gedung_perumahan">
          <div>
            <span class="text-xs text-slate-400 block">Gedung/Perumahan</span>
            <span class="text-slate-800" x-text="detailItem.alamat.gedung_perumahan"></span>
          </div>
        </template>
        <template x-if="detailItem?.alamat?.patokan">
          <div>
            <span class="text-xs text-slate-400 block">Patokan</span>
            <span class="text-slate-800" x-text="detailItem.alamat.patokan"></span>
          </div>
        </template>
        <template x-if="detailItem?.alamat?.label_alamat">
          <div>
            <span class="text-xs text-slate-400 block">Label Alamat</span>
            <span class="text-slate-800" x-text="detailItem.alamat.label_alamat"></span>
          </div>
        </template>
        <template x-if="detailItem?.alamat?.latitude && detailItem?.alamat?.longitude">
          <div class="sm:col-span-2">
            <span class="text-xs text-slate-400 block">Koordinat</span>
            <span class="text-slate-800 font-mono text-xs" x-text="detailItem.alamat.latitude + ', ' + detailItem.alamat.longitude"></span>
          </div>
        </template>
      </div>
    </div>
  </div>

  <x-slot:footer>
    <button type="button" @click="detailShow = false"
      class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">
      Tutup
    </button>
  </x-slot:footer>
</x-modal>
