import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const lokasiApi = {
  async paginate({ page = 1, search = '', perPage = 50 } = {}) {
    const params = new URLSearchParams({
      page,
      per_page: perPage,
      search: search || '',
    });

    return apiFetchJson(`${baseUrl}/inv-lokasi?${params.toString()}`);
  },

  async list(search = '') {
    const payload = await this.paginate({ search });
    return normalizePaginatedResponse(payload).items;
  },

  async getById(id) {
    if (!id) return null;

    try {
      return await apiFetch(`${baseUrl}/inv-lokasi/${id}`);
    } catch {
      return null;
    }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/inv-lokasi`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/inv-lokasi/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/inv-lokasi/${id}`, { method: 'DELETE' });
  },
};