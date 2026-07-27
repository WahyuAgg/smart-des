import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const peminjamanApi = {
  async paginate({ page = 1, search = '', perPage = 20, status } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage });
    if (search) params.set('search', search);
    if (status) params.set('status', status);

    return apiFetchJson(`${baseUrl}/inv-peminjaman?${params.toString()}`);
  },

  async getById(id) {
    if (!id) return null;
    try {
      return await apiFetch(`${baseUrl}/inv-peminjaman/${id}`);
    } catch {
      return null;
    }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/inv-peminjaman`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/inv-peminjaman/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/inv-peminjaman/${id}`, { method: 'DELETE' });
  },

  async kembalikan(id, payload) {
    return apiFetch(`${baseUrl}/inv-peminjaman/${id}/kembalikan`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async batalkan(id) {
    return apiFetch(`${baseUrl}/inv-peminjaman/${id}/batalkan`, {
      method: 'POST',
    });
  },
};