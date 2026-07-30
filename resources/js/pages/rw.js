import { isRequired } from '../utils/validation';
import { rwApi } from '../services/rwApi';
import { dusunApi } from '../services/dusunApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/rwMapper';
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

  dusunList: [],

  async init() {
    await this.loadDusun();
    await this.load();
  },

  async loadDusun() {
    try {
      this.dusunList = await dusunApi.list();
    } catch { this.dusunList = []; }
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await rwApi.paginate({ page, search: this.search });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal memuat data RW.';
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
    if (!isRequired(this.form.dusun_id)) {
      this.error = 'Dusun wajib dipilih.';
      return;
    }
    if (!isRequired(this.form.nomor_rw)) {
      this.error = 'Nomor RW wajib diisi.';
      return;
    }

    this.saving = true;
    this.error = null;

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await rwApi.update(this.editingId, payload);
      } else {
        await rwApi.create(payload);
      }

      this.success = isEdit ? 'Data RW berhasil diperbarui.' : 'Data RW berhasil ditambahkan.';
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menyimpan data RW.';
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
      await rwApi.remove(this.deletingItem.id);
      this.success = 'Data RW berhasil dihapus.';
      this.confirmShow = false;
      this.deletingItem = null;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menghapus data RW.';
    } finally {
      this.loading = false;
    }
  },

  dusunName(dusunId) {
    const d = this.dusunList.find(d => d.id === dusunId);
    return d ? d.nama : '—';
  },
});