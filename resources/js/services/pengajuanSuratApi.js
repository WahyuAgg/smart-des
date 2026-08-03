import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const pengajuanSuratApi = {
  async list({ page = 1, perPage = 15 } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage });
    return apiFetchJson(`${baseUrl}/srt-pengajuan-surat?${params.toString()}`);
  },
  /** @deprecated Use list() instead */
  paginate(opts) { return this.list(opts); },

  async getById(id) {
    if (!id) return null;
    try { return await apiFetch(`${baseUrl}/srt-pengajuan-surat/${id}`); }
    catch { return null; }
  },
};