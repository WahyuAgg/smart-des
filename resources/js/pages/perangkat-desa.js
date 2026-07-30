import { isRequired } from '../utils/validation';
import { jabatanPerangkatApi } from '../services/jabatanPerangkatApi';
import { perangkatDesaApi } from '../services/perangkatDesaApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/perangkatDesaMapper';
import { normalizePaginatedResponse } from '../utils/pagination';

export default () => ({
  loading: false,
  saving: false,
  error: null,
  success: null,
  search: '',

  items: [],
  meta: { current_page: 1, last_page: 1, total: 0, per_page: 10 },

  showModal: false,
  editingId: null,
  form: emptyForm(),

  confirmShow: false,
  deletingItem: null,

  jabatanOptions: [],

  async init() {
    await Promise.all([this.load(), this.loadJabatanOptions()]);
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await perangkatDesaApi.paginate({ page, search: this.search });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal memuat data perangkat desa.';
    } finally {
      this.loading = false;
    }
  },

  async loadJabatanOptions() {
    try {
      const result = await jabatanPerangkatApi.list();
      const items = Array.isArray(result.items) ? result.items : [];
      this.jabatanOptions = items.map(item => ({
        label: `${item.nama} (${item.kode})`,
        value: item.id,
      }));
    } catch (error) {
      console.error('Gagal memuat opsi jabatan:', error);
      this.jabatanOptions = [];
    }
  },

  openCreate() {
    this.editingId = null;
    this.form = emptyForm();
    this.showModal = true;
  },

  openCreateWithJabatan(jabatan) {
    this.editingId = null;
    this.form = emptyForm();
    // pre-fill jabatan based on kode
    const matched = this.jabatanOptions.find(o => o.label.startsWith(jabatan.nama));
    if (matched) {
      this.form.jabatan_perangkat_id = matched.value;
    }
    this.showModal = true;
  },

  openEdit(item) {
    if (!item.perangkat) return;
    this.editingId = item.perangkat.id;
    this.form = mapItemToForm(item.perangkat);
    this.showModal = true;
  },

  async save() {
    if (!isRequired(this.form.nama)) {
      this.error = 'Nama perangkat desa wajib diisi.';
      return;
    }
    if (!isRequired(this.form.jabatan_perangkat_id)) {
      this.error = 'Jabatan perangkat wajib dipilih.';
      return;
    }

    this.saving = true;
    this.error = null;

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await perangkatDesaApi.update(this.editingId, payload);
      } else {
        await perangkatDesaApi.create(payload);
      }

      this.success = isEdit
        ? 'Data perangkat desa berhasil diperbarui.'
        : 'Data perangkat desa berhasil ditambahkan.';
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menyimpan data perangkat desa.';
    } finally {
      this.saving = false;
    }
  },

  openDelete(item) {
    if (!item.perangkat) return;
    this.deletingItem = item;
    this.confirmShow = true;
  },

  async remove() {
    if (!this.deletingItem?.perangkat) return;

    this.loading = true;
    this.error = null;

    try {
      await perangkatDesaApi.remove(this.deletingItem.perangkat.id);
      this.success = 'Data perangkat desa berhasil dihapus.';
      this.deletingItem = null;
      this.confirmShow = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menghapus data perangkat desa.';
    } finally {
      this.loading = false;
    }
  },
});