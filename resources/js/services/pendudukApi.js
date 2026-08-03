import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

const endpoint = 'penduduk';

export const pendudukApi = {
  async list({ page = 1, search = '' } = {}) {
    const params = new URLSearchParams({ page, search: search || '' });
    const payload = await apiFetchJson(`${baseUrl}/${endpoint}?${params.toString()}`);
    return normalizePaginatedResponse(payload);
  },

  async getById(id) {
    if (!id) return null;
    try { return await apiFetch(`${baseUrl}/${endpoint}/${id}`); }
    catch { return null; }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/${endpoint}`, { method: 'POST', body: JSON.stringify(payload) });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/${endpoint}/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/${endpoint}/${id}`, { method: 'DELETE' });
  },
};
