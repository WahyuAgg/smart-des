import { apiFetch, baseUrl } from './httpClient';

const endpoint = 'penduduk';

export const pendudukApi = {
  async list({ page = 1, search = '' } = {}) {
    const params = new URLSearchParams({ page, search: search || '' });
    // Returns the raw paginated payload (current_page, last_page, total, data)
    return apiFetch(`${baseUrl}/${endpoint}?${params.toString()}`);
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/${endpoint}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/${endpoint}/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/${endpoint}/${id}`, { method: 'DELETE' });
  },
};
