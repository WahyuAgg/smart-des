import { Auth } from '../services/auth';
import { pengajuanSuratApi } from '../services/pengajuanSuratApi';
import { UnauthorizedError } from '../services/httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export default () => ({
  loading: false,
  error: null,

  items: [],
  meta: { current_page: 1, last_page: 1, total: 0 },

  // Detail modal
  detailOpen: false,
  detailItem: null,
  detailLoading: false,

  async init() {
    if (!Auth.requireAuth()) return;
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await pengajuanSuratApi.paginate({ page });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal memuat riwayat surat.';
    } finally {
      this.loading = false;
    }
  },

  statusBadgeClass(status) {
    const map = {
      diajukan: 'bg-amber-50 text-amber-700 border-amber-200',
      diproses: 'bg-blue-50 text-blue-700 border-blue-200',
      selesai: 'bg-emerald-50 text-emerald-700 border-emerald-200',
      ditolak: 'bg-red-50 text-red-700 border-red-200',
    };
    return map[status] || 'bg-slate-100 text-slate-600 border-slate-200';
  },

  statusLabel(status) {
    const map = {
      diajukan: 'Diajukan',
      diproses: 'Diproses',
      selesai: 'Selesai',
      ditolak: 'Ditolak',
    };
    return map[status] || status;
  },

  async openDetail(item) {
    this.detailLoading = true;
    this.detailOpen = true;
    this.detailItem = null;

    try {
      const data = await pengajuanSuratApi.getById(item.id);
      this.detailItem = data;
    } catch (e) {
      this.error = e.message || 'Gagal memuat detail surat.';
    } finally {
      this.detailLoading = false;
    }
  },

  closeDetail() {
    this.detailOpen = false;
    this.detailItem = null;
  },

  previewUrl(item) {
    if (!item.file_hasil) return null;
    const base = window.API_BASE_URL?.replace('/api', '') || '';
    return `${base}/storage/${item.file_hasil}`;
  },
});