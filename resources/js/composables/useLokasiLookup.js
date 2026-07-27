import { lokasiApi } from '../services/lokasiApi';
import { normalizePaginatedResponse } from '../utils/pagination';

/**
 * Composable untuk load daftar lokasi (untuk select dropdown).
 * Gunakan: const lokasiLookup = useLokasiLookup();
 * Di template: x-init="lokasiLookup.init()"
 */
export function useLokasiLookup() {
  return {
    items: [],

    async init() {
      try {
        const payload = await lokasiApi.paginate({ perPage: 200 });
        const { items } = normalizePaginatedResponse(payload);
        this.items = items;
      } catch {
        this.items = [];
      }
    },
  };
}