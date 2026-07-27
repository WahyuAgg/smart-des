import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const mutasiApi = {
  async paginate({ page = 1, perPage = 20, jenis, tanggalFrom, tanggalTo, barangId } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage });
    if (jenis) params.set('jenis', jenis);
    if (tanggalFrom) params.set('tanggal_from', tanggalFrom);
    if (tanggalTo) params.set('tanggal_to', tanggalTo);
    if (barangId) params.set('barang_id', barangId);

    return apiFetchJson(`${baseUrl}/inv-mutasi?${params.toString()}`);
  },

  async getById(id) {
    if (!id) return null;
    try {
      return await apiFetch(`${baseUrl}/inv-mutasi/${id}`);
    } catch {
      return null;
    }
  },
};