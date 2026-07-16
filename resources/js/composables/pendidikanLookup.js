import { pendidikanApi } from '../services/pendidikanApi';
import { UnauthorizedError } from '../services/httpClient';

/**
 * Spread this into the Alpine component's data object, e.g.:
 *   export default () => ({ ...pendidikanLookup(), ...otherStuff })
 * `this` inside these methods refers to the merged Alpine component.
 */
export function pendidikanLookup() {
  return {
    pendidikanSearch: '',
    pendidikanOptions: [],
    pendidikanLoading: false,
    pendidikanOpen: false,
    pendidikanSelected: null,

    async loadPendidikanOptions() {
      this.pendidikanLoading = true;

      try {
        this.pendidikanOptions = await pendidikanApi.list();
        return this.pendidikanOptions;
      } catch (error) {
        if (error instanceof UnauthorizedError) return [];
        this.error = error.message || 'Gagal memuat data pendidikan.';
        return [];
      } finally {
        this.pendidikanLoading = false;
      }
    },

    async ensurePendidikanSelection() {
      if (!this.form.pendidikan_id || this.pendidikanSelected?.id === this.form.pendidikan_id) return;

      const selected = await pendidikanApi.getById(this.form.pendidikan_id);
      if (selected) {
        this.pendidikanSelected = selected;
        this.pendidikanSearch = selected.tingkat_pendidikan || '';
      }
    },

    async searchPendidikan() {
      if (this.pendidikanSelected && this.pendidikanSearch !== this.pendidikanSelected.tingkat_pendidikan) {
        this.form.pendidikan_id = '';
        this.pendidikanSelected = null;
      }

      this.pendidikanOpen = true;

      if (this.pendidikanOptions.length === 0) {
        await this.loadPendidikanOptions();
      }
    },

    selectPendidikan(option) {
      this.form.pendidikan_id = option.id;
      this.pendidikanSelected = option;
      this.pendidikanSearch = option.tingkat_pendidikan || '';
      this.pendidikanOpen = false;
    },

    get visiblePendidikanOptions() {
      const query = this.pendidikanSearch.trim().toLowerCase();

      if (!query) return this.pendidikanOptions;

      return this.pendidikanOptions.filter((item) =>
        String(item.tingkat_pendidikan || '').toLowerCase().includes(query)
      );
    },
  };
}
