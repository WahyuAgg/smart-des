import { useAutocompleteLookup } from './useAutocompleteLookup';
import { kategoriBarangApi } from '../services/kategoriBarangApi';

/**
 * Kategori Barang Lookup — wrapped generic (select mode).
 *
 * Gunakan: const kategoriLookup = useKategoriLookup();
 * Template: x-init="kategoriLookup.init()"
 * Akses: kategoriLookup.items
 */
export function useKategoriLookup() {
  return useAutocompleteLookup({
    api: kategoriBarangApi,
    mode: 'select',
  });
}