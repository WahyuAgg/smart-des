import { Auth } from '../services/auth';
import { isRequired } from '../utils/validation';
import { kategoriSuratApi } from '../services/kategoriSuratApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/kategoriSuratMapper';
import { normalizePaginatedResponse } from '../utils/pagination';

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
      const payload = await kategoriSuratApi.paginate({ page, search: this.search });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal memuat data kategori surat.';
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
    if (!isRequired(this.form.kode_kategori_surat)) {
      this.error = 'Kode kategori surat wajib diisi.';
      return;
    }
    if (!isRequired(this.form.nama_kategori_surat)) {
      this.error = 'Nama kategori surat wajib diisi.';
      return;
    }

    this.saving = true;
    this.error = null;

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await kategoriSuratApi.update(this.editingId, payload);
      } else {
        await kategoriSuratApi.create(payload);
      }

      this.success = isEdit ? 'Data kategori surat berhasil diperbarui.' : 'Data kategori surat berhasil ditambahkan.';
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menyimpan data kategori surat.';
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
      await kategoriSuratApi.remove(this.deletingItem.id);
      this.success = 'Data kategori surat berhasil dihapus.';
      this.confirmShow = false;
      this.deletingItem = null;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menghapus data kategori surat.';
    } finally {
      this.loading = false;
    }
  },
});