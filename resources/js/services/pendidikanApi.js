import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizeCollectionResponse, normalizePaginatedResponse } from '../utils/pagination';

export const pendidikanApi = {
  async list({ page = 1, search = '', perPage = 10 } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage, search: search || '' });
    return apiFetchJson(`${baseUrl}/pendidikan?${params.toString()}`);
  },
  /** @deprecated Use list() instead */
  paginate(opts) { return this.list(opts); },

  /**
   * Fetch all pendidikan items as a flat array (no pagination).
   */
  async listAll() {
    const payload = await apiFetchJson(`${baseUrl}/pendidikan`);
    return normalizeCollectionResponse(payload);
  },

  async getById(id) {
    if (!id) return null;
    try { return await apiFetch(`${baseUrl}/pendidikan/${id}`); }
    catch { return null; }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/pendidikan`, { method: 'POST', body: JSON.stringify(payload) });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/pendidikan/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/pendidikan/${id}`, { method: 'DELETE' });
  },
};
