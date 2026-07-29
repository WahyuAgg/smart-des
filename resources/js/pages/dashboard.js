import { Auth } from '../services/auth';
import { dashboardApi } from '../services/dashboardApi';
import { profilDesaApi } from '../services/profilDesaApi';
import { perangkatDesaApi } from '../services/perangkatDesaApi';
import { pengajuanSuratApi } from '../services/pengajuanSuratApi';
import { UnauthorizedError } from '../services/httpClient';

export default () => ({
  /** Data dari API */
  profilDesa: null,
  dashboard: null,
  perangkatDesa: [],
  riwayatSurat: [],
  loading: true,
  error: null,

  async init() {
    if (!Auth.requireAuth()) return;
    await this.fetchAll();
  },

  async fetchAll() {
    this.loading = true;
    this.error = null;

    try {
      const [profilData, dashData, perangkatData, suratData] = await Promise.all([
        profilDesaApi.get(),
        dashboardApi.get(),
        perangkatDesaApi.list(),
        pengajuanSuratApi.paginate({ page: 1, perPage: 10 }),
      ]);

      this.profilDesa = profilData;
      this.dashboard = dashData;
      this.perangkatDesa = perangkatData?.items ?? [];
      this.riwayatSurat = suratData?.data ?? [];
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal memuat data dashboard';
    } finally {
      this.loading = false;
    }
  },

  /** Helper: jumlah dari distribusi_umur */
  get totalDistribusiUmur() {
    if (!this.dashboard?.distribusi_umur) return 0;
    return Object.values(this.dashboard.distribusi_umur).reduce((sum, d) => sum + d.jumlah, 0);
  },

  /** Helper: persentase */
  pct(value, total) {
    if (!total || total === 0) return 0;
    return ((value / total) * 100).toFixed(1);
  },

  /** Format tanggal ke "29 Jul 2026" */
  formatDate(dateStr) {
    if (!dateStr) return '-';
    const d = new Date(dateStr);
    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
  },

  /** Warna untuk chart */
  chartColors: [
    '#0D9488', '#14B8A6', '#2DD4BF', '#5EEAD4',
    '#F59E0B', '#F97316', '#EF4444', '#8B5CF6',
    '#EC4899', '#06B6D4', '#84CC16', '#6366F1',
  ],

  /** Warna untuk distribusi umur */
  ageColors: [
    '#06B6D4', '#0D9488', '#14B8A6', '#2DD4BF',
    '#F59E0B', '#F97316', '#EF4444', '#EC4899',
    '#8B5CF6', '#6366F1', '#84CC16', '#10B981',
    '#3B82F6', '#F43F5E',
  ],

  /** Warna badge status surat */
  badgeColor(status) {
    const map = {
      diajukan: 'bg-yellow-100 text-yellow-700',
      diproses: 'bg-blue-100 text-blue-700',
      selesai: 'bg-green-100 text-green-700',
      ditolak: 'bg-red-100 text-red-700',
    };
    return map[status] || 'bg-slate-100 text-slate-600';
  },

  /** Ikon status surat */
  statusIcon(status) {
    const map = {
      diajukan: 'M12 6v6l4 2',
      diproses: 'M12 8v4l3 3M4 4v5h5',
      selesai: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
      ditolak: 'M18 6L6 18M6 6l12 12',
    };
    return map[status] || 'M12 6v6l4 2';
  },

  /** Ambil warna berdasarkan index */
  color(i) {
    return this.chartColors[i % this.chartColors.length];
  },
  ageColor(i) {
    return this.ageColors[i % this.ageColors.length];
  },
});