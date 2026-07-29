import { Auth } from '../services/auth';
import { galeriApi } from '../services/galeriApi';
import { UnauthorizedError } from '../services/httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export default () => ({
  loading: false,
  error: null,
  search: '',

  items: [],
  meta: { current_page: 1, last_page: 1, total: 0 },

  // Lightbox
  lightboxOpen: false,
  lightboxItem: null,

  async init() {
    if (!Auth.requireAuth()) return;
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await galeriApi.paginate({
        page,
        search: this.search,
        isPublished: true,
        perPage: 12,
      });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal memuat galeri.';
    } finally {
      this.loading = false;
    }
  },

  openLightbox(item) {
    this.lightboxItem = item;
    this.lightboxOpen = true;
  },

  closeLightbox() {
    this.lightboxOpen = false;
    this.lightboxItem = null;
  },
});