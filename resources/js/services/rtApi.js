import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const rtApi = {
  async paginate({ page = 1, search = '', perPage = 50, rwId = '' } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage, search: search || '' });
    if (rwId) params.set('rw_id', rwId);
    return apiFetchJson(`${baseUrl}/ref-rt?${params.toString()}`);
  },

  async list(search = '') {
    const payload = await this.paginate({ search });
    return normalizePaginatedResponse(payload).items;
  },

  async getById(id) {
    if (!id) return null;
    try {
      return await apiFetch(`${baseUrl}/ref-rt/${id}`);
    } catch { return null; }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/ref-rt`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/ref-rt/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/ref-rt/${id}`, { method: 'DELETE' });
  },
};