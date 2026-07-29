{{-- Form: Create / Edit Profil Desa --}}

{{-- Informasi Desa --}}
<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Informasi Desa</h4>
    <p class="text-xs text-slate-400">Data identitas dan kontak desa.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="Nama Desa" model="form.nama" placeholder="Contoh: Curug" required />
    <x-form.input label="Kode Wilayah" model="form.kode" placeholder="Contoh: 3306022050" />
    <x-form.input label="Kode Pos" model="form.kode_pos" placeholder="Contoh: 54172" />
    <x-form.input label="Telepon" model="form.telepon" placeholder="Contoh: 081234567890" />
    <x-form.input label="Email" model="form.email" type="email" placeholder="desa@example.com" />
    <x-form.input label="Website" model="form.website" placeholder="https://desacurug.co.id" />
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Logo</label>
      <template x-if="existingLogoUrl">
        <div class="mb-2">
          <img :src="existingLogoUrl" class="w-20 h-20 rounded-lg object-cover border" />
          <p class="text-xs text-slate-400 mt-1">Logo saat ini. Upload file baru untuk mengganti.</p>
        </div>
      </template>
      <input type="file" accept="image/*" @change="onFileChange('logo', $event)"
             class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Peta PDF</label>
      <template x-if="existingPetaPdfUrl">
        <div class="mb-2">
          <a :href="existingPetaPdfUrl" target="_blank" class="text-xs text-accent hover:underline">Lihat peta saat ini</a>
        </div>
      </template>
      <input type="file" accept=".pdf" @change="onFileChange('peta_pdf', $event)"
             class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
    </div>
  </div>
</section>

<hr class="border-slate-200" />

{{-- Wilayah --}}
<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Wilayah</h4>
    <p class="text-xs text-slate-400">Nama wilayah sesuai dengan data administrasi kependudukan.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="Provinsi" model="form.nama_provinsi" placeholder="Contoh: Jawa Tengah" />
    <x-form.input label="Kabupaten" model="form.nama_kabupaten" placeholder="Contoh: Kabupaten Purworejo" />
    <x-form.input label="Kecamatan" model="form.nama_kecamatan" placeholder="Contoh: Ngombol" />
    <x-form.input label="Desa" model="form.nama_desa" placeholder="Contoh: Curug" />
  </div>
</section>

<hr class="border-slate-200" />

{{-- Visi, Misi, Deskripsi --}}
<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Visi, Misi & Deskripsi</h4>
    <p class="text-xs text-slate-400">Informasi tambahan tentang desa.</p>
  </div>

  <x-form.textarea label="Visi" model="form.visi" placeholder="Visi desa..." rows="2" />
  <x-form.textarea label="Deskripsi" model="form.deskripsi" placeholder="Deskripsi desa..." rows="3" />

  {{-- Misi list --}}
  <div>
    <label class="block text-sm font-medium text-slate-700 mb-2">Misi</label>
    <template x-for="(_, index) in form.misi" :key="index">
      <div class="flex items-center gap-2 mb-2">
        <span class="text-xs text-slate-400 w-6 text-right" x-text="index + 1"></span>
        <input type="text" x-model="form.misi[index]" placeholder="Misi..."
               class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" />
        <button type="button" @click="removeMisi(index)" class="text-red-400 hover:text-red-600 shrink-0">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M6 18 18 6" />
          </svg>
        </button>
      </div>
    </template>
    <button type="button" @click="addMisi()" class="text-xs text-accent hover:text-accent-hover font-medium">
      + Tambah misi
    </button>
  </div>
</section>

<hr class="border-slate-200" />

{{-- Profil Kecamatan --}}
<section class="space-y-4">
  <div>
    <h4 class="text-sm font-semibold text-slate-800">Profil Kecamatan</h4>
    <p class="text-xs text-slate-400">Data camat dan kontak kecamatan.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-form.input label="Nama Camat" model="form.profil_kecamatan.camat" placeholder="Contoh: Budi Santoso" />
    <x-form.input label="NIP Camat" model="form.profil_kecamatan.nip" placeholder="Contoh: 198501012010011001" />
    <x-form.input label="Telepon" model="form.profil_kecamatan.telepon" placeholder="Contoh: 081234567890" />
    <x-form.input label="Email" model="form.profil_kecamatan.email" type="email" placeholder="camat@example.com" />
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Foto Camat</label>
      <template x-if="existingFotoUrl">
        <p class="text-xs text-slate-400 mb-1">Foto saat ini sudah ada. Upload file baru untuk mengganti.</p>
      </template>
      <input type="file" accept="image/*" @change="onFileChange('profil_kecamatan.foto', $event)"
             class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Tanda Tangan Camat</label>
      <template x-if="existingTandaTanganUrl">
        <p class="text-xs text-slate-400 mb-1">Tanda tangan saat ini sudah ada. Upload file baru untuk mengganti.</p>
      </template>
      <input type="file" accept="image/*" @change="onFileChange('profil_kecamatan.tanda_tangan', $event)"
             class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
    </div>
  </div>
</section>

{{-- Actions --}}
<div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
  <button type="button" @click="cancelEdit()"
          class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">
    Batal
  </button>
  <button type="submit" :disabled="saving"
          class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-accent hover:bg-accent-hover disabled:opacity-40">
    <span x-show="!saving" x-text="record ? 'Simpan Perubahan' : 'Simpan'"></span>
    <span x-show="saving">Menyimpan...</span>
  </button>
</div>