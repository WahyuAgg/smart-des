@extends('layouts.app')

@section('title', 'Detail Barang')
@section('page-title', 'Detail Barang')
@section('page-subtitle', 'Informasi lengkap barang inventaris.')

@section('content')
  <div x-data="barangDetail" class="max-w-5xl mx-auto space-y-5">
    @include('components.alert')

    <div x-show="!loading && item">
      {{-- Info Barang --}}
      <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-6">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-lg font-semibold text-slate-800" x-text="item.nama_barang"></h2>
            <p class="text-sm text-slate-500 font-mono" x-text="item.kode_barang"></p>
          </div>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
            :class="stokBadge"
            x-text="'Tersedia: ' + stokTersedia"></span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div><span class="text-slate-500">Kategori:</span> <span class="ml-1 font-medium" x-text="item.kategori?.nama || '—'"></span></div>
          <div><span class="text-slate-500">Lokasi:</span> <span class="ml-1 font-medium" x-text="item.lokasi?.nama || '—'"></span></div>
          <div><span class="text-slate-500">Satuan:</span> <span class="ml-1 font-medium" x-text="item.satuan || '—'"></span></div>
          <div><span class="text-slate-500">Tanggal Perolehan:</span> <span class="ml-1 font-medium" x-text="item.tanggal_perolehan || '—'"></span></div>
          <div><span class="text-slate-500">Total Stok:</span> <span class="ml-1 font-medium" x-text="item.jumlah_total ?? 0"></span></div>
          <div><span class="text-slate-500">Sedang Dipinjam:</span> <span class="ml-1 font-medium" x-text="item.jumlah_dipinjam ?? 0"></span></div>
        </div>

        <div x-show="item.keterangan" class="text-sm">
          <span class="text-slate-500">Keterangan:</span>
          <p class="mt-1 text-slate-700" x-text="item.keterangan"></p>
        </div>
      </div>

      {{-- Riwayat Mutasi --}}
      <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
        <h3 class="text-sm font-semibold text-slate-800 mb-4">Riwayat Mutasi</h3>
        <div x-show="mutasiLoading" class="text-center py-4 text-slate-400">Memuat...</div>
        <div x-show="!mutasiLoading && mutasiItems.length === 0" class="text-center py-4 text-slate-400">Belum ada riwayat mutasi.</div>
        <table x-show="!mutasiLoading && mutasiItems.length > 0" class="w-full text-sm">
          <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
              <th class="px-3 py-2">Tanggal</th>
              <th class="px-3 py-2">Jenis</th>
              <th class="px-3 py-2 text-right">Jumlah</th>
              <th class="px-3 py-2">Keterangan</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <template x-for="m in mutasiItems" :key="m.id">
              <tr>
                <td class="px-3 py-2 text-slate-600" x-text="m.tanggal"></td>
                <td class="px-3 py-2">
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                    :class="jenisBadge(m.jenis)" x-text="jenisLabel(m.jenis)"></span>
                </td>
                <td class="px-3 py-2 text-right font-medium" x-text="m.details?.reduce((a,d) => a + (d.jumlah||0), 0) || 0"></td>
                <td class="px-3 py-2 text-slate-500" x-text="m.keterangan || '—'"></td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>

    <div class="flex justify-start">
      <a href="{{ route('inventaris.barang.index') }}" class="text-sm text-accent hover:text-accent-hover">&larr; Kembali ke daftar barang</a>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('barangDetail', () => ({
      loading: true,
      error: null,
      item: null,
      mutasiLoading: false,
      mutasiItems: [],

      async init() {
        const id = '{{ $id ?? '' }}';
        if (!id) return;

        try {
          const response = await fetch(`/api/inv-barang/${id}`, {
            headers: { Accept: 'application/json', ...(window.Auth?.getHeaders?.() || {}) },
          });
          const json = await response.json();
          this.item = json.data || json;

          // Load riwayat mutasi
          this.mutasiLoading = true;
          try {
            const mutasiResp = await fetch(`/api/inv-barang/${id}/riwayat-mutasi?per_page=10`, {
              headers: { Accept: 'application/json', ...(window.Auth?.getHeaders?.() || {}) },
            });
            const mutasiJson = await mutasiResp.json();
            this.mutasiItems = mutasiJson.data?.data || mutasiJson.data || [];
          } catch (e) {
            this.mutasiItems = [];
          } finally {
            this.mutasiLoading = false;
          }
        } catch (e) {
          this.error = 'Gagal memuat detail barang.';
        } finally {
          this.loading = false;
        }
      },

      get stokTersedia() {
        if (!this.item) return 0;
        return (this.item.jumlah_total || 0) - (this.item.jumlah_dipinjam || 0);
      },

      get stokBadge() {
        const s = this.stokTersedia;
        if (s <= 0) return 'bg-red-100 text-red-700';
        if (s <= (this.item?.jumlah_dipinjam || 0)) return 'bg-yellow-100 text-yellow-700';
        return 'bg-green-100 text-green-700';
      },

      jenisBadge(jenis) {
        const map = { pengadaan: 'bg-green-100 text-green-700', peminjaman: 'bg-blue-100 text-blue-700', pengembalian: 'bg-teal-100 text-teal-700', hilang: 'bg-red-100 text-red-700', ketemu: 'bg-yellow-100 text-yellow-700', opname: 'bg-purple-100 text-purple-700', hapus_stok: 'bg-orange-100 text-orange-700', pembatalan: 'bg-slate-100 text-slate-600' };
        return map[jenis] || 'bg-slate-100 text-slate-600';
      },

      jenisLabel(jenis) {
        const map = { pengadaan: 'Pengadaan', peminjaman: 'Peminjaman', pengembalian: 'Pengembalian', hilang: 'Hilang', ketemu: 'Ketemu', opname: 'Opname', hapus_stok: 'Hapus Stok', pembatalan: 'Pembatalan' };
        return map[jenis] || jenis;
      },
    }));
  });
</script>
@endpush