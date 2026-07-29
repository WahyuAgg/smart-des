{{-- Profil Desa Header --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
  <div class="relative h-32 bg-gradient-to-r from-teal-600 to-teal-400">
    <div class="absolute -bottom-10 left-6">
      <template x-if="profilDesa?.logo_url">
        <img :src="profilDesa.logo_url" alt="Logo Desa"
             class="w-20 h-20 rounded-xl border-4 border-white shadow-md object-cover bg-white" />
      </template>
      <template x-if="!profilDesa?.logo_url">
        <div class="w-20 h-20 rounded-xl border-4 border-white shadow-md bg-teal-100 flex items-center justify-center">
          <span class="text-2xl font-bold text-teal-600" x-text="(profilDesa?.nama || 'D').charAt(0)"></span>
        </div>
      </template>
    </div>
  </div>
  <div class="pt-12 pb-5 px-6">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
      <div>
        <h2 class="text-xl font-bold text-slate-800" x-text="profilDesa?.nama || 'Desa'"></h2>
        <p class="text-sm text-slate-500">
          <span x-text="profilDesa?.alamat || '-'"></span>
          <template x-if="profilDesa?.telepon">
            <span> &middot; <span x-text="profilDesa.telepon"></span></span>
          </template>
        </p>
        <p class="text-xs text-slate-400 mt-0.5">
          <span x-text="profilDesa?.nama_desa || '-'"></span>,
          <span x-text="profilDesa?.nama_kecamatan || '-'"></span>,
          <span x-text="profilDesa?.nama_kabupaten || '-'"></span>,
          <span x-text="profilDesa?.nama_provinsi || '-'"></span>
        </p>
      </div>
      <div class="flex items-center gap-4 text-xs text-slate-500">
        <template x-if="profilDesa?.profil_kecamatan?.camat">
          <div class="text-right">
            <p class="font-medium text-slate-700">Camat</p>
            <p x-text="profilDesa.profil_kecamatan.camat"></p>
          </div>
        </template>
        <template x-if="profilDesa?.kades?.nama">
          <div class="text-right">
            <p class="font-medium text-slate-700">Kepala Desa</p>
            <p x-text="profilDesa.kades.nama"></p>
          </div>
        </template>
      </div>
    </div>
  </div>
</div>