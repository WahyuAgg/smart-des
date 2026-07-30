import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

const endpoint = 'srt-master-field-surat';

export const masterFieldSuratApi = {
  async list({ page = 1, search = '', tipe = '', input_mode = '', source = '' } = {}) {
    const params = new URLSearchParams({ page, search: search || '' });
    if (tipe) params.append('tipe', tipe);
    if (input_mode) params.append('input_mode', input_mode);
    if (source) params.append('source', source);
    const payload = await apiFetchJson(`${baseUrl}/${endpoint}?${params.toString()}`);
    return normalizePaginatedResponse(payload);
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
