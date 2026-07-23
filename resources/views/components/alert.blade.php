{{--
  Alert notifikasi sukses/error untuk halaman CRUD.

  Mengakses properti Alpine dari parent scope:
    error   : string | null — pesan error
    success : string | null — pesan sukses

  Contoh:
    @include('components.alert')
--}}

<div x-show="error" x-cloak x-transition
     class="mb-4 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
  <svg class="w-5 h-5 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
  </svg>
  <div class="flex-1">
    <p class="font-medium">Terjadi kesalahan</p>
    <p x-text="error" class="text-red-600"></p>
  </div>
  <button @click="error = null" class="text-red-400 hover:text-red-600">&times;</button>
</div>

<div x-show="success" x-cloak x-transition
     class="mb-4 flex items-start gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
  <svg class="w-5 h-5 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
    <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
  </svg>
  <p x-text="success" class="flex-1"></p>
  <button @click="success = null" class="text-emerald-400 hover:text-emerald-600">&times;</button>
</div>
