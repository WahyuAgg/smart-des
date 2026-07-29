{{-- Visi & Misi --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
  <div class="flex items-center gap-2 mb-4">
    <div class="w-8 h-8 rounded-lg bg-linear-to-br from-emerald-400 to-teal-600 flex items-center justify-center shadow-sm">
      <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 20h9M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
      </svg>
    </div>
    <h3 class="text-sm font-semibold text-slate-700">Visi & Misi Desa</h3>
  </div>

  <template x-if="profilDesa?.visi || profilDesa?.misi?.length">
    <div>
      <template x-if="profilDesa?.visi">
        <div class="mb-4">
          <div class="flex items-center gap-2 mb-2">
            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600">Visi</span>
          </div>
          <p class="text-sm text-slate-600 leading-relaxed italic border-l-2 border-emerald-300 pl-3" x-text="profilDesa.visi"></p>
        </div>
      </template>
      <template x-if="profilDesa?.misi?.length">
        <div>
          <div class="flex items-center gap-2 mb-2">
            <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Misi</span>
          </div>
          <ul class="space-y-1.5">
            <template x-for="(item, i) in profilDesa.misi" :key="i">
              <li class="text-sm text-slate-600 flex items-start gap-2.5">
                <span class="w-5 h-5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold flex items-center justify-center shrink-0 mt-0.5" x-text="i+1"></span>
                <span x-text="item"></span>
              </li>
            </template>
          </ul>
        </div>
      </template>
    </div>
  </template>

  <template x-if="!profilDesa?.visi && !profilDesa?.misi?.length">
    <p class="text-sm text-slate-400 text-center py-6">Belum ada visi & misi</p>
  </template>
</div>