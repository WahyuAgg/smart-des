import { Auth } from '../services/auth';
import { isRequired } from '../utils/validation';
import { pendudukApi } from '../services/pendudukApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/pendudukMapper';
import { formatDate } from '../utils/date';
import { genderLabel, statusBadge, statusLabel } from '../utils/format';
import { kkLookup } from '../composables/kkLookup';
import { pendidikanLookup } from '../composables/pendidikanLookup';

export default () => ({
  loading: false,
  saving: false,
  error: null,
  success: null,
  search: '',

  items: [],
  meta: { current_page: 1, last_page: 1, total: 0 },

  showModal: false,
  editingId: null,
  form: emptyForm(),

  confirmShow: false,
  deletingItem: null,

  // Autocomplete/lookup state & methods for KK and Pendidikan
  ...kkLookup(),
  ...pendidikanLookup(),

  async init() {
    if (!Auth.requireAuth()) return;
    await Promise.all([this.loadKkOptions(), this.loadPendidikanOptions()]);
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const { items, meta } = await pendudukApi.list({ page, search: this.search });
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal memuat data penduduk.';
    } finally {
      this.loading = false;
    }
  },

  openCreate() {
    this.editingId = null;
    this.form = emptyForm();
    this.resetLookupState();
    this.showModal = true;
  },

  async openEdit(item) {
    this.editingId = item.id;
    this.form = mapItemToForm(item);
    this.syncLookupState();
    this.showModal = true;
    await Promise.all([this.ensureKkSelection(), this.ensurePendidikanSelection()]);
  },

  async save() {
    if (!isRequired(this.form.nik) || !isRequired(this.form.nama_lengkap)) {
      this.error = 'NIK dan nama lengkap wajib diisi.';
      return;
    }

    this.saving = true;
    this.error = null;

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await pendudukApi.update(this.editingId, payload);
      } else {
        await pendudukApi.create(payload);
      }

      this.success = isEdit
        ? 'Data penduduk berhasil diperbarui.'
        : 'Data penduduk berhasil ditambahkan.';
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menyimpan data penduduk.';
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
    this.error = null;

    try {
      await pendudukApi.remove(this.deletingItem.id);
      this.success = 'Data penduduk berhasil dihapus.';
      this.confirmShow = false;
      this.deletingItem = null;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menghapus data penduduk.';
    } finally {
      this.loading = false;
    }
  },

  // Display helpers used directly in the template
  genderLabel,
  statusBadge,
  statusLabel,
  formatDate,

  resetLookupState() {
    this.kkSearch = '';
    this.kkOptions = [];
    this.kkLoading = false;
    this.kkOpen = false;
    this.kkSelected = null;

    this.pendidikanSearch = '';
    this.pendidikanOptions = [];
    this.pendidikanLoading = false;
    this.pendidikanOpen = false;
    this.pendidikanSelected = null;
  },

  syncLookupState() {
    if (this.form.kk_id) {
      this.kkSearch = this.kkSelected?.no_kk || this.kkSearch || '';
    }

    if (this.form.pendidikan_id) {
      this.pendidikanSearch = this.pendidikanSelected?.tingkat_pendidikan || this.pendidikanSearch || '';
    }
  },
});
