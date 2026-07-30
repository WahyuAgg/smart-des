import { paperApi } from '../services/paperApi';
import { UnauthorizedError } from '../services/httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';
import { emptyForm, mapItemToForm, buildFormData } from '../mappers/paperMapper';

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
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await paperApi.paginate({ page, search: this.search, perPage: 10 });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal memuat data artikel.';
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
    this.saving = true;
    this.error = null;
    this.success = null;

    try {
      const fd = buildFormData(this.form);

      if (this.editingId) {
        await paperApi.update(this.editingId, fd);
        this.success = 'Artikel berhasil diperbarui.';
      } else {
        await paperApi.create(fd);
        this.success = 'Artikel berhasil ditambahkan.';
      }

      this.showModal = false;
      await this.load();
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal menyimpan artikel.';
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
    this.saving = true;

    try {
      await paperApi.remove(this.deletingItem.id);
      this.success = 'Artikel berhasil dihapus.';
      this.confirmShow = false;
      this.deletingItem = null;
      await this.load();
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal menghapus artikel.';
    } finally {
      this.saving = false;
    }
  },

  onFileChange(field, event) {
    const file = event.target?.files?.[0] || null;
    this.form[field] = file;
  },
});