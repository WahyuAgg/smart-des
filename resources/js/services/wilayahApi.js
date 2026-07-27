import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizeCollectionResponse } from '../utils/pagination';

export const wilayahApi = {
  async list(level, { parent = '', search = '', limit = 1000 } = {}) {
    const params = new URLSearchParams({
      level,
      search: search || '',
      limit,
    });

    if (parent) {
      params.set('parent', parent);
    }

    const payload = await apiFetchJson(`${baseUrl}/wilayah?${params.toString()}`);
    return normalizeCollectionResponse(payload);
  },

  async getByCode(level, code) {
    if (!level || !code) return null;

    try {
      return await apiFetch(`${baseUrl}/wilayah/level/${level}/code/${code}`);
    } catch {
      return null;
    }
  },
};