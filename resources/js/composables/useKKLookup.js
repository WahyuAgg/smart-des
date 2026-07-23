import { kkApi } from '../services/kkApi';
import { UnauthorizedError } from '../services/httpClient';

/**
 * Spread this into the Alpine component's data object, e.g.:
 *   export default () => ({ ...useKKLookup(), ...otherStuff })
 * `this` inside these methods refers to the merged Alpine component.
 */
export function useKKLookup() {
  return {
    kkSearch: '',
    kkOptions: [],
    kkLoading: false,
    kkOpen: false,
    kkSelected: null,

    async loadKkOptions(search = '') {
      this.kkLoading = true;

      try {
        this.kkOptions = await kkApi.list(search);
        return this.kkOptions;
      } catch (error) {
        if (error instanceof UnauthorizedError) return [];
        this.error = error.message || 'Gagal memuat data KK.';
        return [];
      } finally {
        this.kkLoading = false;
      }
    },

    async ensureKkSelection() {
      if (!this.form.kk_id || this.kkSelected?.id === this.form.kk_id) return;

      const selected = await kkApi.getById(this.form.kk_id);
      if (selected) {
        this.kkSelected = selected;
        this.kkSearch = selected.no_kk || '';
      }
    },

    async searchKk() {
      if (this.kkSelected && this.kkSearch !== this.kkSelected.no_kk) {
        this.form.kk_id = '';
        this.kkSelected = null;
      }

      this.kkOpen = true;
      await this.loadKkOptions(this.kkSearch.trim());
    },

    selectKk(option) {
      this.form.kk_id = option.id;
      this.kkSelected = option;
      this.kkSearch = option.no_kk || '';
      this.kkOpen = false;
    },

    get visibleKkOptions() {
      return this.kkOptions;
    },
  };
}