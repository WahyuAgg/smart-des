import { appInfoApi } from '../services/appInfoApi';

export default () => ({
  loading: true,
  error: null,
  info: null,

  async init() {
    await this.load();
  },

  async load() {
    this.loading = true;
    this.error = null;
    this.$store.notify.clear();

    try {
      this.info = await appInfoApi.get();
    } catch (e) {
      this.error = e.message || 'Gagal memuat informasi aplikasi.';
    } finally {
      this.loading = false;
    }
  },
});