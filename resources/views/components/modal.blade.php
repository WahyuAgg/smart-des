{{--
  Modal generik, dipakai lintas halaman master-data.
  Konvensi: parent Alpine harus punya variabel boolean untuk visibility.

  Props:
    show     : nama variabel Alpine untuk kondisi tampil (default: 'showModal')
    title    : judul modal (bisa string statis atau ekspresi x-text lewat slot title)
    maxWidth : kelas max-width tailwind (default: 'max-w-lg')
--}}
@props([
    'show' => 'showModal',
    'title' => null,
    'maxWidth' => 'max-w-lg',
])

<div x-show="{{ $show }}" x-cloak
     class="fixed inset-0 z-40 flex items-center justify-center p-4">

  <div x-show="{{ $show }}" x-transition.opacity
       @click="{{ $show }} = false"
       class="absolute inset-0 bg-slate-900/40"></div>

  <div x-show="{{ $show }}"
       x-transition:enter="transition ease-out duration-150"
       x-transition:enter-start="opacity-0 scale-95"
       x-transition:enter-end="opacity-100 scale-100"
       @click.outside="{{ $show }} = false"
       class="relative bg-white rounded-xl shadow-lg w-full {{ $maxWidth }} max-h-[90vh] flex flex-col">

    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
      <h3 class="text-sm font-semibold text-slate-800">{{ $title }}</h3>
      <button type="button" @click="{{ $show }} = false" class="text-slate-400 hover:text-slate-600">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M6 18 18 6" />
        </svg>
      </button>
    </div>

    <div class="px-5 py-4 overflow-y-auto">
      {{ $slot }}
    </div>

    @isset($footer)
      <div class="px-5 py-4 border-t border-slate-200 flex justify-end gap-3">
        {{ $footer }}
      </div>
    @endisset
  </div>
</div>
