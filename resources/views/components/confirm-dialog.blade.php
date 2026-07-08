{{--
  Dialog konfirmasi generik (dipakai untuk hapus data, dll).

  Props:
    show    : nama variabel Alpine untuk visibility (default: 'confirmShow')
    title   : judul dialog
    confirm : ekspresi Alpine yang dipanggil saat tombol konfirmasi diklik
    danger  : true = tombol merah (default), false = tombol accent
--}}
@props([
    'show' => 'confirmShow',
    'title' => 'Hapus data?',
    'confirm' => 'confirmDelete()',
    'danger' => true,
])

<div x-show="{{ $show }}" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
  <div x-show="{{ $show }}" x-transition.opacity @click="{{ $show }} = false" class="absolute inset-0 bg-slate-900/40"></div>

  <div x-show="{{ $show }}"
       x-transition:enter="transition ease-out duration-150"
       x-transition:enter-start="opacity-0 scale-95"
       x-transition:enter-end="opacity-100 scale-100"
       class="relative bg-white rounded-xl shadow-lg w-full max-w-sm p-5">
    <h3 class="text-sm font-semibold text-slate-800 mb-1">{{ $title }}</h3>
    <div class="text-sm text-slate-500 mb-5">
      {{ $slot }}
    </div>
    <div class="flex justify-end gap-3">
      <button type="button" @click="{{ $show }} = false"
              class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">
        Batal
      </button>
      <button type="button" @click="{{ $confirm }}"
              class="px-4 py-2 rounded-lg text-sm font-medium text-white {{ $danger ? 'bg-red-600 hover:bg-red-700' : 'bg-accent hover:bg-accent-hover' }}">
        Ya, Hapus
      </button>
    </div>
  </div>
</div>
