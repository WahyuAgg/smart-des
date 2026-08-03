import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const paperApi = {
  async list({ page = 1, search = '', perPage = 12, status, tahun } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage });
    if (search) params.set('search', search);
    if (status) params.set('status', status);
    if (tahun) params.set('tahun', tahun);

    return apiFetchJson(`${baseUrl}/papers?${params.toString()}`);
  },
  /** @deprecated Use list() instead */
  paginate(opts) { return this.list(opts); },

  async getById(id) {
    if (!id) return null;
    try {
      return await apiFetch(`${baseUrl}/papers/${id}`);
    } catch {
      return null;
    }
  },

  async create(formData) {
    return apiFetch(`${baseUrl}/papers`, {
      method: 'POST',
      body: formData,
    });
  },

  async update(id, formData) {
    formData.append('_method', 'PUT');
    return apiFetch(`${baseUrl}/papers/${id}`, {
      method: 'POST',
      body: formData,
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/papers/${id}`, { method: 'DELETE' });
  },
};