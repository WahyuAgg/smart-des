{{-- Expects Alpine parent scope with: step (number 1-4) --}}
@php
  $labels = ['Jenis Surat', 'Data NIK', 'Lengkapi Data', 'Unduh Surat'];
@endphp

<ol class="flex items-center w-full mb-8">
  @foreach ($labels as $i => $label)
    @php $n = $i + 1; @endphp
    <li class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">
      <div class="flex items-center gap-2 shrink-0">
        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold border-2 transition"
             :class="{
               'bg-accent border-accent text-white': step > {{ $n }},
               'border-accent text-accent bg-white': step === {{ $n }},
               'border-slate-300 text-slate-400 bg-white': step < {{ $n }},
             }">
          <template x-if="step > {{ $n }}">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
            </svg>
          </template>
          <template x-if="step <= {{ $n }}">
            <span>{{ $n }}</span>
          </template>
        </div>
        <span class="text-sm font-medium hidden sm:inline"
              :class="step === {{ $n }} ? 'text-slate-800' : 'text-slate-400'">{{ $label }}</span>
      </div>
      @if (!$loop->last)
        <div class="flex-1 h-0.5 mx-3" :class="step > {{ $n }} ? 'bg-accent' : 'bg-slate-200'"></div>
      @endif
    </li>
  @endforeach
</ol>
