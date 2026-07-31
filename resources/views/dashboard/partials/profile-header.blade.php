{{-- Profil Desa — Modern Hero Banner --}}
<div class="relative overflow-hidden bg-slate-600 text-white shadow-xl border border-slate-700/50">
  {{-- Subtle decorative glow background --}}
  <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-blue-500/10 blur-3xl pointer-events-none"></div>

  <div class="relative p-6 lg:p-8 flex flex-col md:flex-row items-center md:items-start lg:items-center gap-6 lg:gap-8">
    {{-- Logo Desa --}}
    <div class="shrink-0 relative group">
      <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
      
      <template x-if="profilDesa?.logo_url">
        <img :src="profilDesa.logo_url" alt="Logo Desa"
             class="relative w-40 h-40 lg:w-40 lg:h-40 rounded-2xl border-1 border-white/20 shadow-2xl object-contain bg-slate-500/90 backdrop-blur-md" />
      </template>
      <template x-if="!profilDesa?.logo_url">
        <div class="relative w-40 h-40 lg:w-40 lg:h-40 rounded-2xl border-1 border-white/20 shadow-2xl bg-slate-800/90 flex items-center justify-center backdrop-blur-md">
          <span class="text-5xl font-black text-emerald-400" x-text="(profilDesa?.nama || 'D').charAt(0)"></span>
        </div>
      </template>
    </div>

    {{-- Info Profil & Detail --}}
    <div class="flex-1 text-center md:text-left space-y-3 min-w-0">
      <div>
        <h2 class="text-2xl lg:text-3xl font-extrabold tracking-tight text-white" x-text="profilDesa?.nama || 'Desa Curug'"></h2>
        <p class="text-xs lg:text-sm font-medium text-slate-300 mt-1 flex flex-wrap items-center justify-center md:justify-start gap-x-2 gap-y-1">
          <span x-text="profilDesa?.nama_desa || '-'"></span>
          <span>&bull;</span>
          <span x-text="profilDesa?.nama_kecamatan || '-'"></span>
          <span>&bull;</span>
          <span x-text="profilDesa?.nama_kabupaten || '-'"></span>
          <span>&bull;</span>
          <span x-text="profilDesa?.nama_provinsi || '-'"></span>
          <template x-if="profilDesa?.kode_pos">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 ml-1" x-text="profilDesa.kode_pos"></span>
          </template>
        </p>
      </div>

      <template x-if="profilDesa?.alamat">
        <p class="text-slate-300 text-sm leading-relaxed max-w-2xl line-clamp-2" x-text="profilDesa?.alamat"></p>
      </template>

      {{-- Kontak Info Badges --}}
      <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 pt-1 text-xs">
        <template x-if="profilDesa?.telepon">
          <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800/80 border border-slate-700/60 text-slate-300">
            <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.6A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7 12.9 12.9 0 0 0 .7 2.8 2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5 12.9 12.9 0 0 0 2.8.7A2 2 0 0 1 22 16.9z"/></svg>
            <span x-text="profilDesa.telepon"></span>
          </div>
        </template>

        <template x-if="profilDesa?.email">
          <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800/80 border border-slate-700/60 text-slate-300">
            <svg class="w-3.5 h-3.5 text-blue-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <span x-text="profilDesa.email"></span>
          </div>
        </template>

        <template x-if="profilDesa?.website">
          <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800/80 border border-slate-700/60 text-slate-300">
            <svg class="w-3.5 h-3.5 text-indigo-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            <span x-text="profilDesa.website"></span>
          </div>
        </template>
      </div>
    </div>

    {{-- Kartu Kepala Desa --}}
    <template x-if="profilDesa?.kades?.nama">
      <div class="w-full md:w-auto shrink-0 pt-2 md:pt-0">
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900/90 backdrop-blur-md rounded-xl p-4 border border-slate-700/80 min-w-[200px] text-center md:text-left shadow-lg">
          <div class="flex items-center justify-center md:justify-start gap-2 mb-1">
            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
            <p class="text-[10px] uppercase font-bold tracking-wider text-emerald-400">Kepala Desa</p>
          </div>
          <p class="text-base font-bold text-white tracking-wide" x-text="profilDesa.kades.nama"></p>
          <template x-if="profilDesa.kades.nip">
            <p class="text-xs text-slate-400 mt-1 font-mono" x-text="'NIP. ' + profilDesa.kades.nip"></p>
          </template>
        </div>
      </div>
    </template>
  </div>
</div>