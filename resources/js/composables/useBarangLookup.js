import { barangApi } from '../services/barangApi';
import { normalizePaginatedResponse } from '../utils/pagination';

/**
 * Composable untuk autocomplete/search barang (untuk form peminjaman).
 */
export function useBarangLookup() {
  return {
    items: [],

    async init() {
      try {
        const payload = await barangApi.paginate({ perPage: 200 });
        const { items } = normalizePaginatedResponse(payload);
        this.items = items;
      } catch {
        this.items = [];
      }
    },

    getById(id) {
      return this.items.find(i => i.id === Number(id));
    },
  };
}