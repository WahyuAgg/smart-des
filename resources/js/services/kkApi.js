import { apiFetch, baseUrl } from './httpClient';

export const kkApi = {
  async list(search = '') {
    const params = new URLSearchParams({ per_page: '10', search });
    const payload = await apiFetch(`${baseUrl}/kk?${params.toString()}`);
    return payload.data ?? payload;
  },

  async getById(id) {
    if (!id) return null;

    try {
      return await apiFetch(`${baseUrl}/kk/${id}`);
    } catch {
      return null;
    }
  },
};
