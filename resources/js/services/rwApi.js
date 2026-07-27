import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const rwApi = {
  async paginate({ page = 1, search = '', perPage = 50, dusunId = '' } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage, search: search || '' });
    if (dusunId) params.set('dusun_id', dusunId);
    return apiFetchJson(`${baseUrl}/ref-rw?${params.toString()}`);
  },

  async list(search = '') {
    const payload = await this.paginate({ search });
    return normalizePaginatedResponse(payload).items;
  },

  async getById(id) {
    if (!id) return null;
    try {
      return await apiFetch(`${baseUrl}/ref-rw/${id}`);
    } catch { return null; }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/ref-rw`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/ref-rw/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/ref-rw/${id}`, { method: 'DELETE' });
  },
};