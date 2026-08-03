import { useAutocompleteLookup } from './useAutocompleteLookup';
import { barangApi } from '../services/barangApi';

/**
 * Barang Lookup — wrapped generic (select mode).
 *
 * Gunakan: const barangLookup = useBarangLookup();
 * Template: x-init="barangLookup.init()"
 * Akses: barangLookup.items, barangLookup.getById(id)
 */
export function useBarangLookup() {
  return useAutocompleteLookup({
    api: barangApi,
    mode: 'select',
  });
}