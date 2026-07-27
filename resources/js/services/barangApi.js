import { apiFetch, apiFetchJson, baseUrl } from './httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

export const barangApi = {
  async paginate({ page = 1, search = '', perPage = 20, kategoriId, lokasiId, stockMinim } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage });
    if (search) params.set('search', search);
    if (kategoriId) params.set('kategori_id', kategoriId);
    if (lokasiId) params.set('lokasi_id', lokasiId);
    if (stockMinim) params.set('stock_minim', '1');

    return apiFetchJson(`${baseUrl}/inv-barang?${params.toString()}`);
  },

  async getById(id) {
    if (!id) return null;
    try {
      return await apiFetch(`${baseUrl}/inv-barang/${id}`);
    } catch {
      return null;
    }
  },

  async create(payload) {
    return apiFetch(`${baseUrl}/inv-barang`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async update(id, payload) {
    return apiFetch(`${baseUrl}/inv-barang/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async remove(id) {
    return apiFetch(`${baseUrl}/inv-barang/${id}`, { method: 'DELETE' });
  },

  // Aksi stok
  async pengadaan(id, payload) {
    return apiFetch(`${baseUrl}/inv-barang/${id}/pengadaan`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async hilang(id, payload) {
    return apiFetch(`${baseUrl}/inv-barang/${id}/hilang`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async ketemu(id, payload) {
    return apiFetch(`${baseUrl}/inv-barang/${id}/ketemu`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async opname(id, payload) {
    return apiFetch(`${baseUrl}/inv-barang/${id}/opname`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  async hapusStok(id, payload) {
    return apiFetch(`${baseUrl}/inv-barang/${id}/hapus-stok`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
  },

  // Riwayat
  async riwayatMutasi(id, { page = 1, perPage = 10 } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage });
    return apiFetchJson(`${baseUrl}/inv-barang/${id}/riwayat-mutasi?${params.toString()}`);
  },

  async riwayatPeminjaman(id, { page = 1, perPage = 10 } = {}) {
    const params = new URLSearchParams({ page, per_page: perPage });
    return apiFetchJson(`${baseUrl}/inv-barang/${id}/riwayat-peminjaman?${params.toString()}`);
  },
};