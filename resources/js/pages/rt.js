import { Auth } from '../services/auth';
import { isRequired } from '../utils/validation';
import { rtApi } from '../services/rtApi';
import { rwApi } from '../services/rwApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/rtMapper';
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

  rwList: [],

  async init() {
    if (!Auth.requireAuth()) return;
    await this.loadRw();
    await this.load();
  },

  async loadRw() {
    try {
      this.rwList = await rwApi.list();
    } catch { this.rwList = []; }
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await rtApi.paginate({ page, search: this.search });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal memuat data RT.';
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
    if (!isRequired(this.form.rw_id)) {
      this.error = 'RW wajib dipilih.';
      return;
    }
    if (!isRequired(this.form.nomor_rt)) {
      this.error = 'Nomor RT wajib diisi.';
      return;
    }

    this.saving = true;
    this.error = null;

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await rtApi.update(this.editingId, payload);
      } else {
        await rtApi.create(payload);
      }

      this.success = isEdit ? 'Data RT berhasil diperbarui.' : 'Data RT berhasil ditambahkan.';
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menyimpan data RT.';
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
      await rtApi.remove(this.deletingItem.id);
      this.success = 'Data RT berhasil dihapus.';
      this.confirmShow = false;
      this.deletingItem = null;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menghapus data RT.';
    } finally {
      this.loading = false;
    }
  },

  rwLabel(rwId) {
    const r = this.rwList.find(r => r.id === rwId);
    return r ? `RW ${r.nomor_rw}` : '—';
  },
});