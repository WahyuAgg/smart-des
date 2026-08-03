import { UnauthorizedError } from '../services/httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';

/**
 * Generic CRUD composable — eliminates ~50 lines of boilerplate per page.
 *
 * Usage:
 *   import { useCrud } from '../composables/useCrud';
 *   import { kkApi } from '../services/kkApi';
 *   import * as mapper from '../mappers/kkMapper';
 *
 *   export default () => ({
 *     ...useCrud({ api: kkApi, mapper, entityName: 'KK' }),
 *     async init() { await this.load(); },
 *     // custom methods...
 *   });
 *
 * @param {Object} options
 * @param {Object}  options.api          - API service object (must have paginate, getById, create, update, remove)
 * @param {Object}  [options.mapper]     - Mapper object (must have emptyForm, mapItemToForm, buildPayload)
 * @param {string}  [options.entityName] - Human-readable entity name for messages (e.g. 'KK')
 * @param {Object}  [options.loadOptions] - Extra options passed to api.paginate() on every load
 * @param {Function} [options.validate]  - Optional async validation: async (form) => errorMessage | null
 * @param {boolean} [options.useNormalize] - Whether to normalize paginated response (default: true)
 * @param {Object}  [options.initialForm] - Override initial form state (for complex forms)
 */
export function useCrud({
  api,
  mapper,
  entityName = 'Data',
  loadOptions = {},
  validate = null,
  useNormalize = true,
  initialForm = undefined,
} = {}) {
  const label = entityName;

  return {
    // ── State ──
    loading: false,
    error: null,
    saving: false,
    search: '',

    items: [],
    meta: { current_page: 1, last_page: 1, total: 0 },

    showModal: false,
    editingId: null,
    form: initialForm !== undefined ? initialForm : (mapper?.emptyForm() ?? {}),

    confirmShow: false,
    deletingItem: null,

    // ── Methods ──

    async load(page = 1) {
      this.loading = true;
      this.error = null;
      this.$store.notify.clear();

      try {
        if (api.list) {
          const payload = await api.list({ page, search: this.search, ...loadOptions });
          if (useNormalize) {
            const result = normalizePaginatedResponse(payload);
            this.items = result.items;
            this.meta = result.meta;
          } else {
            this.items = payload.items ?? payload;
            this.meta = payload.meta ?? { current_page: 1, last_page: 1, total: 0 };
          }
        } else {
          // Fallback for APIs without paginate (e.g. single-record)
          const data = await api.get();
          this.items = data;
        }
      } catch (error) {
        if (error instanceof UnauthorizedError) return;
        this.error = error.message || `Gagal memuat ${label}.`;
      } finally {
        this.loading = false;
      }
    },

    openCreate() {
      this.editingId = null;
      this.form = initialForm !== undefined ? { ...initialForm } : (mapper?.emptyForm() ?? {});
      this.showModal = true;
    },

    openEdit(item) {
      this.editingId = item.id;
      this.form = mapper?.mapItemToForm(item) ?? { ...item };
      this.showModal = true;
    },

    async save() {
      // Run validation — support both options.validate and this.validate()
      const validateFn = validate || this.validate;
      if (validateFn) {
        const validationError = typeof validateFn === 'function' ? validateFn.call(this, this.form) : null;
        if (validationError) {
          this.$store.notify.show(validationError, 'error');
          return;
        }
      }

      this.saving = true;
      this.$store.notify.clear();

      try {
        const isEdit = !!this.editingId;
        const payload = mapper?.buildPayload
          ? mapper.buildPayload(this.form)
          : mapper?.buildFormData
            ? mapper.buildFormData(this.form)
            : this.form;

        if (isEdit) {
          if (api.update) {
            await api.update(this.editingId, payload);
          } else {
            await api.create(payload); // fallback for single-record APIs
          }
        } else {
          await api.create(payload);
        }

        this.$store.notify.show(isEdit ? `${label} berhasil diperbarui.` : `${label} berhasil ditambahkan.`, 'success');
        this.showModal = false;
        await this.load(this.meta.current_page);
      } catch (error) {
        if (error instanceof UnauthorizedError) return;
        this.$store.notify.show(error.message || `Gagal menyimpan ${label}.`, 'error');
      } finally {
        this.saving = false;
      }
    },

    openDelete(item) {
      this.deletingItem = item;
      this.confirmShow = true;
    },

    async remove() {
      if (!this.deletingItem) return;

      this.loading = true;
      this.$store.notify.clear();

      try {
        const id = this.deletingItem.id ?? this.deletingItem;
        await api.remove(id);
        this.$store.notify.show(`${label} berhasil dihapus.`, 'success');
        this.confirmShow = false;
        this.deletingItem = null;
        await this.load(this.meta.current_page);
      } catch (error) {
        if (error instanceof UnauthorizedError) return;
        this.$store.notify.show(error.message || `Gagal menghapus ${label}.`, 'error');
      } finally {
        this.loading = false;
      }
    },
  };
}