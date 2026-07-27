import { kategoriBarangApi } from '../services/kategoriBarangApi';
import { normalizePaginatedResponse } from '../utils/pagination';

/**
 * Composable untuk load daftar kategori barang (untuk select dropdown).
 * Gunakan: const kategoriLookup = useKategoriLookup();
 * Di template: x-init="kategoriLookup.init()"
 */
export function useKategoriLookup() {
  return {
    items: [],

    async init() {
      try {
        const payload = await kategoriBarangApi.paginate({ perPage: 200 });
        const { items } = normalizePaginatedResponse(payload);
        this.items = items;
      } catch {
        this.items = [];
      }
    },
  };
}