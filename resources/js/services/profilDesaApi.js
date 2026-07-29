import { apiFetch, apiFetchJson, baseUrl } from './httpClient';

/**
 * API service for Profil Desa (single-record resource).
 * All endpoints use multipart/form-data because of file uploads (logo, peta_pdf, foto, tanda_tangan).
 */
export const profilDesaApi = {
  /**
   * Get the single Profil Desa record.
   */
  async get() {
    return apiFetch(`${baseUrl}/ref-profil-desa`);
  },

  /**
   * Create Profil Desa + profil kecamatan.
   * @param {FormData} formData
   */
  async create(formData) {
    return apiFetch(`${baseUrl}/ref-profil-desa`, {
      method: 'POST',
      body: formData,
    });
  },

  /**
   * Update Profil Desa + profil kecamatan.
   * Uses POST with _method=PUT to support multipart file uploads.
   * @param {FormData} formData
   */
  async update(formData) {
    formData.append('_method', 'PUT');
    return apiFetch(`${baseUrl}/ref-profil-desa`, {
      method: 'POST',
      body: formData,
    });
  },

  /**
   * Delete Profil Desa and all related data.
   */
  async remove() {
    return apiFetch(`${baseUrl}/ref-profil-desa`, { method: 'DELETE' });
  },
};