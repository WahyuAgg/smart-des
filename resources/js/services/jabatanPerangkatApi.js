import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const jabatanPerangkatApi = {
  async paginate({ page = 1, search = '', perPage = 10 } = {}) {
    const params = new URLSearchParams({
      page,
      per_page: perPage,
      search: search || '',
    });

    return apiFetchJson(`${baseUrl}/ref-jabatan-perangkat?${params.toString()}`);
  },

  async list() {
    const payload = await apiFetchJson(`${baseUrl}/ref-jabatan-perangkat?per_page=100&aktif=true`);
    return normalizePaginatedResponse(payload);
  },

  async getById(id) {
    if (!id) return null;
    try {
      return await apiFetch(`${baseUrl}/ref-jabatan-perangkat/${id}`);
    } catch {
      return null;
    }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/ref-jabatan-perangkat`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/ref-jabatan-perangkat/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/ref-jabatan-perangkat/${id}`, { method: 'DELETE' });
  },
};