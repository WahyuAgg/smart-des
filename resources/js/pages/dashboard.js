import { Auth } from '../services/auth';

export default () => ({
  /** Data dari API */
  profilDesa: null,
  dashboard: null,
  loading: true,
  error: null,

  async init() {
    await this.fetchAll();
  },

  async fetchAll() {
    this.loading = true;
    this.error = null;

    try {
      const token = Auth.getToken();
      const headers = {
        Accept: 'application/json',
        Authorization: `Bearer ${token}`,
      };

      const [profilRes, dashRes] = await Promise.all([
        fetch(`${window.API_BASE_URL}/ref-profil-desa`, { headers }),
        fetch(`${window.API_BASE_URL}/dashboard`, { headers }),
      ]);

      if (!profilRes.ok || !dashRes.ok) {
        throw new Error('Gagal memuat data dashboard');
      }

      const profilJson = await profilRes.json();
      const dashJson = await dashRes.json();

      this.profilDesa = profilJson.data;
      this.dashboard = dashJson.data;
    } catch (e) {
      this.error = e.message;
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

  /** Ambil warna berdasarkan index */
  color(i) {
    return this.chartColors[i % this.chartColors.length];
  },
  ageColor(i) {
    return this.ageColors[i % this.ageColors.length];
  },
});