import { Auth } from '../services/auth';
import { paperApi } from '../services/paperApi';
import { UnauthorizedError } from '../services/httpClient';

export default () => ({
  loading: true,
  error: null,
  item: null,
  id: null,

  async init() {
    if (!Auth.requireAuth()) return;
    // Get ID from route param
    const el = this.$el;
    this.id = el?.dataset?.id;
    await this.load();
  },

  async load() {
    this.loading = true;
    this.error = null;

    try {
      this.item = await paperApi.getById(this.id);
      if (!this.item) {
        this.error = 'Artikel tidak ditemukan.';
      }
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal memuat artikel.';
    } finally {
      this.loading = false;
    }
  },
});