import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const kkApi = {
  /**
   * Paginated list — returns normalized {success, data, message} envelope.
   * @param {Object} options
   * @param {number} [options.page=1]
   * @param {string} [options.search='']
   * @param {number} [options.perPage=10]
   */
  async list({ page = 1, search = '', perPage = 10 } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage, search: search || '' });
    return apiFetchJson(`${baseUrl}/kk?${params.toString()}`);
  },
  /** @deprecated Use list() instead */
  paginate(opts) { return this.list(opts); },

  /**
   * Fetch all items as a flat array (for dropdowns, etc).
   * @param {string} [search='']
   * @returns {Promise<Array>}
   */
  async listAll(search = '') {
    const payload = await this.list({ search });
    return normalizePaginatedResponse(payload).items;
  },

  async getById(id) {
    if (!id) return null;
    try {
      return await apiFetch(`${baseUrl}/kk/${id}`);
    } catch { return null; }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/kk`, {
      method: 'POST',
      body: JSON.stringify(payload),
    });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/kk/${id}`, {
      method: 'PUT',
      body: JSON.stringify(payload),
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/kk/${id}`, { method: 'DELETE' });
  },
};
