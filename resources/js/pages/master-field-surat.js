import { Auth } from '../services/auth';
import { isRequired } from '../utils/validation';
import { masterFieldSuratApi } from '../services/masterFieldSuratApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/masterFieldSuratMapper';
import { inputModeLabel, inputModeBadge } from '../utils/inputMode';

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

  async init() {
    if (!Auth.requireAuth()) return;
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const { items, meta } = await masterFieldSuratApi.list({ page, search: this.search });
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal memuat data field surat.';
    } finally {
      this.loading = false;
    }
  },

  openCreate() {
    this.editingId = null;
    this.form = emptyForm();
    this.showModal = true;
  },

  openEdit(item) {
    this.editingId = item.id;
    this.form = mapItemToForm(item);
    this.showModal = true;
  },

  async save() {
    if (
      !isRequired(this.form.nama) ||
      !isRequired(this.form.label) ||
      !isRequired(this.form.input_mode) ||
      !isRequired(this.form.tipe)
    ) {
      this.error = 'Nama, label, tipe, dan input mode wajib diisi.';
      return;
    }

    this.saving = true;
    this.error = null;

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await masterFieldSuratApi.update(this.editingId, payload);
      } else {
        await masterFieldSuratApi.create(payload);
      }

      this.showModal = false;
      this.success = isEdit ? 'Field surat berhasil diperbarui.' : 'Field surat berhasil ditambahkan.';
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menyimpan data.';
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
      await masterFieldSuratApi.remove(this.deletingItem.id);
      this.success = 'Field surat berhasil dihapus.';
      this.confirmShow = false;
      this.deletingItem = null;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menghapus data.';
    } finally {
      this.loading = false;
    }
  },

  // Display helpers used directly in the template
  inputModeLabel,
  inputModeBadge,
});
