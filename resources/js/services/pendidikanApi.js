import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizeCollectionResponse, normalizePaginatedResponse } from '../utils/pagination';

export const pendidikanApi = {
  async paginate({ page = 1, search = '', perPage = 10 } = {}) {
    const params = new URLSearchParams({
      page,
      per_page: perPage,
      search: search || '',
    });

    return apiFetchJson(`${baseUrl}/pendidikan?${params.toString()}`);
  },

  async list() {
    const payload = await apiFetchJson(`${baseUrl}/pendidikan`);
    return normalizeCollectionResponse(payload);
  },

  async getById(id) {
    if (!id) return null;

    try {
      return await apiFetch(`${baseUrl}/pendidikan/${id}`);
    } catch {
      return null;
    }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/pendidikan`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/pendidikan/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/pendidikan/${id}`, { method: 'DELETE' });
  },
};
