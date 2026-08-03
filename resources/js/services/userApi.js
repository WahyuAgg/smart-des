import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const userApi = {
  async list({ page = 1, search = '', role = '', perPage = 10 } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage });
    if (search) params.set('search', search);
    if (role) params.set('role', role);

    return apiFetchJson(`${baseUrl}/users?${params.toString()}`);
  },
  /** @deprecated Use list() instead */
  paginate(opts) { return this.list(opts); },

  async getById(id) {
    if (!id) return null;
    try { return await apiFetch(`${baseUrl}/users/${id}`); }
    catch { return null; }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/users`, { method: 'POST', body: JSON.stringify(payload) });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/users/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/users/${id}`, { method: 'DELETE' });
  },

  async toggleActive(id) {
    return apiFetch(`${baseUrl}/users/${id}/toggle-active`, { method: 'POST' });
  },

  async fetchRoles() {
    return apiFetch(`${baseUrl}/roles`);
  },
};