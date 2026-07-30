import { isRequired } from '../utils/validation';
import { jenisSuratApi } from '../services/jenisSuratApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm } from '../mappers/jenisSuratMapper';
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
  templateFile: null,

  confirmShow: false,
  deletingItem: null,

  // PDF preview
  previewUrl: null,
  showPreview: false,

  // Kategori lookup
  kategoriOptions: [],

  async init() {
    await this.loadKategoriOptions();
    await this.load();
  },

  async loadKategoriOptions() {
    try {
      const { kategoriSuratApi } = await import('../services/kategoriSuratApi');
      const payload = await kategoriSuratApi.paginate({ perPage: 200 });
      const { items } = normalizePaginatedResponse(payload);
      this.kategoriOptions = items.map((k) => ({
        value: k.id,
        label: `${k.kode_kategori_surat} - ${k.nama_kategori_surat}`,
      }));
    } catch {
      this.kategoriOptions = [];
    }
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await jenisSuratApi.paginate({ page, search: this.search });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal memuat data jenis surat.';
    } finally {
      this.loading = false;
    }
  },

  openCreate() {
    this.editingId = null;
    this.form = emptyForm();
    this.templateFile = null;
    this.showModal = true;
  },

  openEdit(item) {
    this.editingId = item.id;
    this.form = mapItemToForm(item);
    this.templateFile = null;
    this.showModal = true;
  },

  addPendudukField() {
    this.form.penduduk_fields.push({
      temp_id: `field_${Date.now()}`,
      kode: '',
      label: '',
      deskripsi: '',
      wajib: false,
    });
  },

  removePendudukField(index) {
    this.form.penduduk_fields.splice(index, 1);
  },

  onTemplateChange(event) {
    const file = event.target.files?.[0];
    this.templateFile = file || null;
  },

  async save() {
    if (!isRequired(this.form.kategori_surat_id)) {
      this.error = 'Kategori surat wajib dipilih.';
      return;
    }
    if (!isRequired(this.form.kode_jenis_surat)) {
      this.error = 'Kode jenis surat wajib diisi.';
      return;
    }
    if (!isRequired(this.form.nama_jenis_surat)) {
      this.error = 'Nama jenis surat wajib diisi.';
      return;
    }

    this.saving = true;
    this.error = null;

    try {
      const isEdit = !!this.editingId;

      if (isEdit) {
        await jenisSuratApi.update(this.editingId, this.form, this.templateFile);
      } else {
        await jenisSuratApi.create(this.form, this.templateFile);
      }

      this.success = isEdit
        ? 'Data jenis surat berhasil diperbarui.'
        : 'Data jenis surat berhasil ditambahkan.';
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menyimpan data jenis surat.';
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
      await jenisSuratApi.remove(this.deletingItem.id);
      this.success = 'Data jenis surat berhasil dihapus.';
      this.confirmShow = false;
      this.deletingItem = null;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menghapus data jenis surat.';
    } finally {
      this.loading = false;
    }
  },

  openPreview(url) {
    if (!url) {
      this.error = 'Tidak ada file template PDF untuk ditampilkan.';
      return;
    }
    this.previewUrl = url;
    this.showPreview = true;
  },

  closePreview() {
    this.showPreview = false;
    this.previewUrl = null;
  },
});