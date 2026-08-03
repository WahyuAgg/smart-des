import { useAutocompleteLookup } from './useAutocompleteLookup';
import { pendidikanApi } from '../services/pendidikanApi';

/**
 * Pendidikan Autocomplete Lookup — wrapped generic.
 *
 * Spread into the Alpine component's data:
 *   export default () => ({ ...usePendidikanLookup(), ...otherStuff })
 *
 * Provides: pendidikanSearch, pendidikanOptions, pendidikanLoading,
 *           pendidikanOpen, pendidikanSelected, loadPendidikanOptions(),
 *           ensurePendidikanSelection(), searchPendidikan(),
 *           selectPendidikan(), visiblePendidikanOptions()
 */
export function usePendidikanLookup() {
  return useAutocompleteLookup({
    api: pendidikanApi,
    prefix: 'pendidikan',
    labelField: 'tingkat_pendidikan',
    formField: 'pendidikan_id',
    filterClient: true,
  });
}