import { apiFetch, apiFetchJson, baseUrl } from './httpClient';

export const galeriApi = {
  async list({ page = 1, search = '', perPage = 12, isPublished } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage });
    if (search) params.set('search', search);
    if (isPublished !== undefined) params.set('is_published', isPublished ? '1' : '0');

    return apiFetchJson(`${baseUrl}/galeri?${params.toString()}`);
  },
  /** @deprecated Use list() instead */
  paginate(opts) { return this.list(opts); },

  async getById(id) {
    if (!id) return null;
    try {
      return await apiFetch(`${baseUrl}/galeri/${id}`);
    } catch {
      return null;
    }
  },

  async create(formData) {
    return apiFetch(`${baseUrl}/galeri`, {
      method: 'POST',
      body: formData,
    });
  },

  async update(id, formData) {
    formData.append('_method', 'PUT');
    return apiFetch(`${baseUrl}/galeri/${id}`, {
      method: 'POST',
      body: formData,
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/galeri/${id}`, { method: 'DELETE' });
  },
};