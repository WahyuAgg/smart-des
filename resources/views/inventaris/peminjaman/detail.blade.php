@extends('layouts.app')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')
@section('page-subtitle', 'Informasi lengkap peminjaman barang.')

@section('content')
  <div x-data="peminjamanDetail" class="max-w-5xl mx-auto space-y-5">
    @include('components.alert')

    <div x-show="!loading && item">
      {{-- Header --}}
      <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-6">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-lg font-semibold text-slate-800" x-text="'Peminjaman: ' + (item?.nomor ?? '')"></h2>
            <p class="text-sm text-slate-500" x-text="item?.nama_peminjam ?? ''"></p>
          </div>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
            :class="statusBadge(item?.status)"
            x-text="statusLabel(item?.status)"></span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div><span class="text-slate-500">Tanggal Pinjam:</span> <span class="ml-1 font-medium" x-text="$formatDate(item?.tanggal_pinjam)"></span></div>
          <div><span class="text-slate-500">Rencana Kembali:</span> <span class="ml-1 font-medium" x-text="$formatDate(item?.tanggal_rencana_kembali)"></span></div>
          <div x-show="item?.tanggal_kembali"><span class="text-slate-500">Tgl. Kembali:</span> <span class="ml-1 font-medium" x-text="$formatDate(item?.tanggal_kembali)"></span></div>
        </div>

        <div x-show="item?.keterangan" class="text-sm">
          <span class="text-slate-500">Keterangan:</span>
          <p class="mt-1 text-slate-700" x-text="item?.keterangan"></p>
        </div>
      </div>

      {{-- Barang yang Dipinjam --}}
      <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
        <h3 class="text-sm font-semibold text-slate-800 mb-4">Barang yang Dipinjam</h3>
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
              <th class="px-4 py-2">Barang</th>
              <th class="px-4 py-2 text-right">Jumlah Pinjam</th>
              <th class="px-4 py-2 text-right">Jumlah Kembali</th>
              <th class="px-4 py-2 text-right">Jumlah Hilang</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <template x-for="det in item?.details || []" :key="det.id">
              <tr>
                <td class="px-4 py-2" x-text="det.barang?.nama_barang || '—'"></td>
                <td class="px-4 py-2 text-right font-medium" x-text="det.jumlah_pinjam ?? 0"></td>
                <td class="px-4 py-2 text-right" x-text="det.jumlah_kembali ?? 0"></td>
                <td class="px-4 py-2 text-right" x-text="det.jumlah_hilang ?? 0"></td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>

      {{-- Form Pengembalian (jika status dipinjam) --}}
      <div x-show="item?.status === 'dipinjam'" class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
        <h3 class="text-sm font-semibold text-slate-800 mb-4">Form Pengembalian</h3>
        <p class="text-xs text-slate-500 mb-4">Catat jumlah barang yang dikembalikan dan/atau hilang.</p>

        <template x-for="(ret, idx) in returns" :key="idx">
          <div class="flex items-end gap-3 mb-3 p-3 bg-slate-50 rounded-lg">
            <div class="flex-1">
              <label class="block text-xs font-medium text-slate-700 mb-1">Barang</label>
              <span class="text-sm font-medium" x-text="ret.barang_nama"></span>
            </div>
            <div class="w-28">
              <label class="block text-xs font-medium text-slate-700 mb-1">Kembali</label>
              <input type="number" x-model="ret.jumlah_kembali" min="0" placeholder="0"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
            <div class="w-28">
              <label class="block text-xs font-medium text-slate-700 mb-1">Hilang</label>
              <input type="number" x-model="ret.jumlah_hilang" min="0" placeholder="0"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
          </div>
        </template>

        <div class="flex justify-end gap-3 mt-4">
          <button type="button" @click="submitReturns()" :disabled="savingReturns"
            class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 disabled:opacity-40">
            <span x-show="!savingReturns">Kembalikan Barang</span>
            <span x-show="savingReturns">Menyimpan...</span>
          </button>
        </div>
      </div>
    </div>

    <div class="flex justify-start">
      <a href="{{ route('inventaris.peminjaman.index') }}" class="text-sm text-accent hover:text-accent-hover">&larr; Kembali ke daftar peminjaman</a>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('peminjamanDetail', () => ({
      loading: true,
      error: null,
      success: null,
      item: null,
      savingReturns: false,
      returns: [],

      async init() {
        const id = '{{ $id ?? '' }}';
        if (!id) return;

        try {
          this.item = await window.peminjamanApi.getById(id);

          // Init form returns
          if (this.item?.details) {
            this.returns = this.item.details.map(d => ({
              barang_id: d.barang_id,
              barang_nama: d.barang?.nama_barang || '—',
              jumlah_kembali: d.jumlah_kembali ?? (d.jumlah_pinjam || 0),
              jumlah_hilang: d.jumlah_hilang ?? 0,
            }));
          }
        } catch (e) {
          this.error = e.message || 'Gagal memuat detail peminjaman.';
        } finally {
          this.loading = false;
        }
      },

      async submitReturns() {
        if (!this.item) return;
        this.savingReturns = true;
        this.error = null;

        try {
          const payload = {
            returns: this.returns.map(r => ({
              barang_id: r.barang_id,
              jumlah_kembali: Number(r.jumlah_kembali) || 0,
              jumlah_hilang: Number(r.jumlah_hilang) || 0,
            })),
          };

          await window.peminjamanApi.kembalikan(this.item.id, payload);

          this.success = 'Barang berhasil dikembalikan.';
          this.item = await window.peminjamanApi.getById(this.item.id);
        } catch (e) {
          this.error = e.message || 'Gagal mengembalikan barang.';
        } finally {
          this.savingReturns = false;
        }
      },

      statusBadge(status) {
        const map = { dipinjam: 'bg-blue-100 text-blue-700', dikembalikan: 'bg-green-100 text-green-700', dibatalkan: 'bg-red-100 text-red-700', sebagian: 'bg-yellow-100 text-yellow-700' };
        return map[status] || 'bg-slate-100 text-slate-600';
      },
      statusLabel(status) {
        const map = { dipinjam: 'Dipinjam', dikembalikan: 'Dikembalikan', dibatalkan: 'Dibatalkan', sebagian: 'Sebagian' };
        return map[status] || status;
      },
    }));
  });
</script>
@endpush