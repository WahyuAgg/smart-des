import { apiFetch, baseUrl } from './httpClient';

export const pendidikanApi = {
  async list() {
    const payload = await apiFetch(`${baseUrl}/pendidikan`);
    return payload.data ?? payload;
  },

  async getById(id) {
    if (!id) return null;

    try {
      return await apiFetch(`${baseUrl}/pendidikan/${id}`);
    } catch {
      return null;
    }
  },
};
