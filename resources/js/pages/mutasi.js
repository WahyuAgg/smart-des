import { mutasiApi } from '../services/mutasiApi';
import { UnauthorizedError } from '../services/httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export default () => ({
  loading: false,

  items: [],
  meta: { current_page: 1, last_page: 1, total: 0 },

  filterJenis: '',
  filterTanggalFrom: '',
  filterTanggalTo: '',

  async init() {
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.$store.notify.clear();

    try {
      const payload = await mutasiApi.list({
        page,
        jenis: this.filterJenis || undefined,
        tanggalFrom: this.filterTanggalFrom || undefined,
        tanggalTo: this.filterTanggalTo || undefined,
      });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal memuat data mutasi.', 'error');
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
});