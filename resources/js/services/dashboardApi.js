import { apiFetch, baseUrl } from './httpClient';

/**
 * API service for Dashboard (read-only statistics).
 */
export const dashboardApi = {
  /**
   * Get dashboard statistics data.
   * Returns: total_penduduk, jumlah_laki_laki, jumlah_perempuan, jumlah_kk,
   *          distribusi_umur, distribusi_pendidikan, distribusi_pekerjaan, distribusi_agama
   */
  async get() {
    return apiFetch(`${baseUrl}/dashboard`);
  },
};