import { apiFetch, apiFetchJson, baseUrl, UnauthorizedError } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';
import { buildFormData } from '../mappers/jenisSuratMapper';

export const jenisSuratApi = {
  async list({ page = 1, search = '', perPage = 50 } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage, search: search || '' });
    return apiFetchJson(`${baseUrl}/srt-jenis-surat?${params.toString()}`);
  },
  /** @deprecated Use list() instead */
  paginate(opts) { return this.list(opts); },

  async listAll(search = '') {
    const payload = await this.list({ search });
    return normalizePaginatedResponse(payload).items;
  },

  async getById(id) {
    if (!id) return null;
    try {
      return await apiFetch(`${baseUrl}/srt-jenis-surat/${id}`);
    } catch { return null; }
  },

  /**
   * Create with multipart/form-data (supports file upload).
   * @param {Object} form - The form state object
   * @param {File|null} templateFile - The template file to upload
   */
  async create(form, templateFile = null) {
    const fd = buildFormData(form, templateFile);
    return apiFetch(`${baseUrl}/srt-jenis-surat`, {
      method: 'POST',
      body: fd,
    });
  },

  /**
   * Update with multipart/form-data (supports file upload).
   * Laravel uses POST + _method=PUT for multipart PUT.
   * @param {number} id
   * @param {Object} form - The form state object
   * @param {File|null} templateFile - The template file to upload
   */
  async update(id, form, templateFile = null) {
    const fd = buildFormData(form, templateFile);
    fd.append('_method', 'PUT');
    return apiFetch(`${baseUrl}/srt-jenis-surat/${id}`, {
      method: 'POST',
      body: fd,
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/srt-jenis-surat/${id}`, { method: 'DELETE' });
  },
};