@extends('layouts.app')

@section('title', 'Detail Mutasi')
@section('page-title', 'Detail Mutasi')
@section('page-subtitle', 'Informasi lengkap mutasi stok barang.')

@section('content')
  <div x-data="mutasiDetail" class="max-w-4xl mx-auto space-y-5">
    @include('components.alert')

    <div x-show="!loading && item">
      <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-6">
        {{-- Header --}}
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-lg font-semibold text-slate-800" x-text="'Mutasi: ' + (item?.nomor ?? '')"></h2>
            <p class="text-sm text-slate-500" x-text="$formatDate(item?.tanggal)"></p>
          </div>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
            :class="jenisBadge(item?.jenis)"
            x-text="jenisLabel(item?.jenis)"></span>
        </div>

        {{-- Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
          <div>
            <span class="text-slate-500">No. Mutasi:</span>
            <span class="ml-2 font-medium" x-text="item?.nomor ?? ''"></span>
          </div>
          <div>
            <span class="text-slate-500">Tanggal:</span>
            <span class="ml-2 font-medium" x-text="$formatDate(item?.tanggal)"></span>
          </div>
          <div x-show="item?.peminjaman">
            <span class="text-slate-500">No. Peminjaman:</span>
            <span class="ml-2 font-medium" x-text="item?.peminjaman?.nomor"></span>
          </div>
          <div class="md:col-span-2" x-show="item?.keterangan">
            <span class="text-slate-500">Keterangan:</span>
            <p class="mt-1 text-slate-700" x-text="item?.keterangan"></p>
          </div>
        </div>

        {{-- Detail Barang --}}
        <div>
          <h4 class="text-sm font-semibold text-slate-800 mb-3">Barang dalam Mutasi Ini</h4>
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                <th class="px-4 py-2">Barang</th>
                <th class="px-4 py-2 text-right">Jumlah</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <template x-for="det in item?.details || []" :key="det.id">
                <tr>
                  <td class="px-4 py-2" x-text="det.barang?.nama_barang || '—'"></td>
                  <td class="px-4 py-2 text-right font-medium" x-text="det.jumlah"></td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>

      <div class="flex justify-start">
        <a href="{{ route('inventaris.mutasi.index') }}" class="text-sm text-accent hover:text-accent-hover">&larr; Kembali ke daftar mutasi</a>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('mutasiDetail', () => ({
      loading: true,
      error: null,
      item: null,

      async init() {
        const id = '{{ $id ?? '' }}';
        if (!id) return;

        try {
          this.item = await window.mutasiApi.getById(id);
        } catch (e) {
          this.error = e.message || 'Gagal memuat detail mutasi.';
        } finally {
          this.loading = false;
        }
      },

      jenisBadge(jenis) {
        const map = {
          pengadaan: 'bg-green-100 text-green-700',
          peminjaman: 'bg-blue-100 text-blue-700',
          pengembalian: 'bg-teal-100 text-teal-700',
          hilang: 'bg-red-100 text-red-700',
          ketemu: 'bg-yellow-100 text-yellow-700',
          opname: 'bg-purple-100 text-purple-700',
          hapus_stok: 'bg-orange-100 text-orange-700',
          pembatalan: 'bg-slate-100 text-slate-600',
        };
        return map[jenis] || 'bg-slate-100 text-slate-600';
      },

      jenisLabel(jenis) {
        const map = {
          pengadaan: 'Pengadaan',
          peminjaman: 'Peminjaman',
          pengembalian: 'Pengembalian',
          hilang: 'Hilang',
          ketemu: 'Ketemu',
          opname: 'Opname',
          hapus_stok: 'Hapus Stok',
          pembatalan: 'Pembatalan',
        };
        return map[jenis] || jenis;
      },
    }));
  });
</script>
@endpush