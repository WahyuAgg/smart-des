import { Auth } from '../services/auth';
import { profilDesaApi } from '../services/profilDesaApi';
import { UnauthorizedError } from '../services/httpClient';

export default () => ({
  loading: true,
  error: null,
  pdfUrl: null,
  zoom: 1,
  rotation: 0,

  async init() {
    if (!Auth.requireAuth()) return;
    await this.loadPeta();
  },

  async loadPeta() {
    this.loading = true;
    this.error = null;

    try {
      const data = await profilDesaApi.get();
      this.pdfUrl = data?.peta_pdf_url || null;
      if (!this.pdfUrl) {
        this.error = 'Belum ada peta desa yang diunggah.';
      }
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal memuat peta desa.';
    } finally {
      this.loading = false;
    }
  },

  zoomIn() {
    this.zoom = Math.min(this.zoom + 0.25, 3);
  },

  zoomOut() {
    this.zoom = Math.max(this.zoom - 0.25, 0.25);
  },

  zoomReset() {
    this.zoom = 1;
    this.rotation = 0;
  },

  rotateRight() {
    this.rotation = (this.rotation + 90) % 360;
  },
});