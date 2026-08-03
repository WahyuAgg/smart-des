import { useAutocompleteLookup } from './useAutocompleteLookup';
import { kkApi } from '../services/kkApi';

/**
 * KK Autocomplete Lookup — wrapped generic.
 *
 * Spread into the Alpine component's data:
 *   export default () => ({ ...useKKLookup(), ...otherStuff })
 *
 * Provides: kkSearch, kkOptions, kkLoading, kkOpen, kkSelected,
 *           loadKkOptions(), ensureKkSelection(), searchKk(),
 *           selectKk(), visibleKkOptions()
 */
export function useKKLookup() {
  return useAutocompleteLookup({
    api: kkApi,
    prefix: 'kk',
    labelField: 'no_kk',
    formField: 'kk_id',
    filterClient: false,
  });
}