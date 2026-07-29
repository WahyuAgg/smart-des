{{-- Profil Desa — Full-width Hero Banner --}}
<div class="relative overflow-hidden bg-slate-700 text-white">
  {{-- Decorative shapes --}}
  <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5 blur-2xl"></div>
  <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-white/5 blur-xl"></div>
  <div class="absolute top-1/2 right-1/3 w-32 h-32 rounded-full bg-white/5 blur-lg"></div>

  <div class="relative px-6 py-8 lg:py-10 flex flex-col lg:flex-row lg:items-center gap-6">
    {{-- Logo --}}
    <template x-if="profilDesa?.logo_url">
      <img :src="profilDesa.logo_url" alt="Logo Desa"
           class="w-20 h-20 lg:w-24 lg:h-24 rounded-2xl border-4 border-white/30 shadow-xl object-cover bg-white shrink-0" />
    </template>
    <template x-if="!profilDesa?.logo_url">
      <div class="w-20 h-20 lg:w-24 lg:h-24 rounded-2xl border-4 border-white/30 shadow-xl bg-white/15 flex items-center justify-center shrink-0 backdrop-blur-sm">
        <span class="text-4xl font-bold text-white/80" x-text="(profilDesa?.nama || 'D').charAt(0)"></span>
      </div>
    </template>

    {{-- Info --}}
    <div class="flex-1 min-w-0">
      <h2 class="text-2xl lg:text-3xl font-bold tracking-tight" x-text="profilDesa?.nama || 'Desa Curug'"></h2>
      <p class="mt-1 text-slate-100 text-sm lg:text-base leading-relaxed max-w-2xl" x-text="profilDesa?.alamat || '-'"></p>
      <p class="text-slate-200 text-xs lg:text-sm mt-0.5">
        <span x-text="profilDesa?.nama_desa || '-'"></span>,
        <span x-text="profilDesa?.nama_kecamatan || '-'"></span>,
        <span x-text="profilDesa?.nama_kabupaten || '-'"></span>,
        <span x-text="profilDesa?.nama_provinsi || '-'"></span>
        <template x-if="profilDesa?.kode_pos">
          <span> &middot; <span x-text="profilDesa.kode_pos"></span></span>
        </template>
      </p>
      {{-- Kontak --}}
      <div class="flex flex-wrap gap-4 mt-3 text-xs text-slate-200">
        <template x-if="profilDesa?.telepon">
          <span class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.6A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7 12.9 12.9 0 0 0 .7 2.8 2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5 12.9 12.9 0 0 0 2.8.7A2 2 0 0 1 22 16.9z"/></svg>
            <span x-text="profilDesa.telepon"></span>
          </span>
        </template>
        <template x-if="profilDesa?.email">
          <span class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <span x-text="profilDesa.email"></span>
          </span>
        </template>
        <template x-if="profilDesa?.website">
          <span class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            <span x-text="profilDesa.website"></span>
          </span>
        </template>
      </div>
    </div>

    {{-- Kades --}}
    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 shrink-0">
      <template x-if="profilDesa?.kades?.nama">
        <div class="bg-white/15 backdrop-blur-sm rounded-xl px-6 py-4 border border-white/20 min-w-50">
          <p class="text-xs uppercase tracking-wider text-slate-200 font-semibold">Kepala Desa</p>
          <p class="text-lg font-bold mt-1" x-text="profilDesa.kades.nama"></p>
          <template x-if="profilDesa.kades.nip">
            <p class="text-xs text-slate-300 mt-1" x-text="'NIP. ' + profilDesa.kades.nip"></p>
          </template>
        </div>
      </template>
    </div>
  </div>
</div>