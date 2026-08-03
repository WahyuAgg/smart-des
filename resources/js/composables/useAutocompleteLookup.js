import { UnauthorizedError } from '../services/httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

/**
 * Generic Autocomplete Lookup Composable
 *
 * Dua mode:
 * 1. `autocomplete` (default) — spread into component, semua state & method pakai prefix.
 *    Cocok untuk: KK, Pendidikan lookup dengan dropdown search.
 * 2. `select` — return sbg object, tinggal `items` + `init()`.
 *    Cocok untuk: Kategori, Lokasi, Barang (select dropdown).
 *
 * @param {Object} options
 * @param {Object}  options.api            - API service (harus punya .listAll() atau .list())
 * @param {string}  [options.mode]         - 'autocomplete' | 'select'
 * @param {string}  [options.prefix]       - Prefix properti (contoh: 'kk' → kkSearch, kkOptions)
 * @param {string}  [options.labelField]   - Field yang ditampilkan (contoh: 'no_kk', 'tingkat_pendidikan')
 * @param {string}  [options.formField]    - Field di form untuk menyimpan ID (contoh: 'kk_id', 'pendidikan_id')
 * @param {number}  [options.perPage]      - Maks item per request
 * @param {boolean} [options.filterClient] - Apakah filter/search dilakukan client-side (via visibleOptions)
 */
export function useAutocompleteLookup({
  api,
  mode = 'autocomplete',
  prefix = '',
  labelField = 'name',
  formField = null,
  perPage = 200,
  filterClient = true,
} = {}) {
  // ── Mode Select: return sederhana ──
  if (mode === 'select') {
    return {
      items: [],

      async init() {
        try {
          if (api.listAll) {
            this.items = await api.listAll();
          } else {
            const payload = await api.list({ perPage });
            const { items } = normalizePaginatedResponse(payload);
            this.items = items;
          }
        } catch {
          this.items = [];
        }
      },

      getById(id) {
        return this.items.find(i => i.id === Number(id));
      },
    };
  }

  // ── Mode Autocomplete: spread dengan prefix ──
  const p = prefix ? prefix.charAt(0).toUpperCase() + prefix.slice(1) : '';
  const searchKey = `${prefix}Search`;
  const optionsKey = `${prefix}Options`;
  const loadingKey = `${prefix}Loading`;
  const openKey = `${prefix}Open`;
  const selectedKey = `${prefix}Selected`;

  return {
    // State
    [searchKey]: '',
    [optionsKey]: [],
    [loadingKey]: false,
    [openKey]: false,
    [selectedKey]: null,

    async [`load${p}Options`](search = '') {
      this[loadingKey] = true;

      try {
        if (api.listAll) {
          this[optionsKey] = await api.listAll(search);
        } else {
          const payload = await api.list({ search, perPage });
          const { items } = normalizePaginatedResponse(payload);
          this[optionsKey] = items;
        }
        return this[optionsKey];
      } catch (error) {
        if (error instanceof UnauthorizedError) return [];
        this.$store.notify.show(error.message || `Gagal memuat data ${prefix}.`, 'error');
        return [];
      } finally {
        this[loadingKey] = false;
      }
    },

    async [`ensure${p}Selection`]() {
      const formVal = this.form?.[formField];
      if (!formVal || this[selectedKey]?.id === formVal) return;

      if (api.getById) {
        const selected = await api.getById(formVal);
        if (selected) {
          this[selectedKey] = selected;
          this[searchKey] = String(selected[labelField] || '');
        }
      }
    },

    async [`search${p}`]() {
      if (this[selectedKey] && this[searchKey] !== String(this[selectedKey][labelField] || '')) {
        if (this.form && formField) this.form[formField] = '';
        this[selectedKey] = null;
      }

      this[openKey] = true;

      if (filterClient && this[optionsKey].length > 0) {
        // Sudah punya data, filter client-side via visibleOptions
        return;
      }
      await this[`load${p}Options`](this[searchKey].trim());
    },

    [`select${p}`](option) {
      if (this.form && formField) this.form[formField] = option.id;
      this[selectedKey] = option;
      this[searchKey] = String(option[labelField] || '');
      this[openKey] = false;
    },

    [`visible${p}Options`]() {
      if (!filterClient) return this[optionsKey];
      const query = this[searchKey].trim().toLowerCase();
      if (!query) return this[optionsKey];
      return this[optionsKey].filter(item =>
        String(item[labelField] || '').toLowerCase().includes(query)
      );
    },
  };
}