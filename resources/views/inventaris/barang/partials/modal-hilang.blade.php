<div x-show="stockAction === 'hilang'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
  <div x-show="stockAction === 'hilang'" x-transition.opacity @click="closeStockAction()" class="absolute inset-0 bg-slate-900/40"></div>
  <div x-show="stockAction === 'hilang'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative bg-white rounded-xl shadow-lg w-full max-w-md p-5">
    <h3 class="text-sm font-semibold text-slate-800 mb-1">Barang Hilang</h3>
    <p class="text-xs text-slate-500 mb-4">Catat barang hilang untuk <strong x-text="stockItem?.nama_barang"></strong></p>

    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Hilang <span class="text-red-500">*</span></label>
        <input type="number" x-model="stockForm.jumlah" min="1" placeholder="Masukkan jumlah"
          class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
        <textarea x-model="stockForm.keterangan" placeholder="Keterangan kehilangan..." rows="2"
          class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"></textarea>
      </div>
    </div>

    <div class="flex justify-end gap-3 mt-5">
      <button type="button" @click="closeStockAction()" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 border border-slate-300 hover:bg-slate-50">Batal</button>
      <button type="button" @click="submitStockAction()" :disabled="stockSaving || !stockForm.jumlah"
        class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 disabled:opacity-40">
        <span x-show="!stockSaving">Simpan</span>
        <span x-show="stockSaving">Menyimpan...</span>
      </button>
    </div>
  </div>
</div>