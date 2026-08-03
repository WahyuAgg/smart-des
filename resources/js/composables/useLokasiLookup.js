import { useAutocompleteLookup } from './useAutocompleteLookup';
import { lokasiApi } from '../services/lokasiApi';

/**
 * Lokasi Lookup — wrapped generic (select mode).
 *
 * Gunakan: const lokasiLookup = useLokasiLookup();
 * Template: x-init="lokasiLookup.init()"
 * Akses: lokasiLookup.items
 */
export function useLokasiLookup() {
  return useAutocompleteLookup({
    api: lokasiApi,
    mode: 'select',
  });
}