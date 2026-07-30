import { paperApi } from '../services/paperApi';
import { UnauthorizedError } from '../services/httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export default () => ({
  loading: false,
  error: null,
  search: '',
  tahun: '',

  items: [],
  meta: { current_page: 1, last_page: 1, total: 0 },

  async init() {
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await paperApi.paginate({
        page,
        search: this.search,
        status: 'published',
        tahun: this.tahun || undefined,
        perPage: 12,
      });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal memuat artikel.';
    } finally {
      this.loading = false;
    }
  },

  goToDetail(id) {
    window.location.href = `/bacaan/${id}`;
  },
});