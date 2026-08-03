import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const kategoriSuratApi = {
  async list({ page = 1, search = '', perPage = 50 } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage, search: search || '' });
    return apiFetchJson(`${baseUrl}/srt-kategori-surat?${params.toString()}`);
  },
  /** @deprecated Use list() instead */
  paginate(opts) { return this.list(opts); },

  async listAll(search = '') {
    const payload = await this.list({ search });
    return normalizePaginatedResponse(payload).items;
  },

  async getById(id) {
    if (!id) return null;
    try { return await apiFetch(`${baseUrl}/srt-kategori-surat/${id}`); }
    catch { return null; }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/srt-kategori-surat`, { method: 'POST', body: JSON.stringify(payload) });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/srt-kategori-surat/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/srt-kategori-surat/${id}`, { method: 'DELETE' });
  },
};