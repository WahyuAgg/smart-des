import { isRequired } from '../utils/validation';
import { jenisSuratApi } from '../services/jenisSuratApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm } from '../mappers/jenisSuratMapper';
import { normalizePaginatedResponse } from '../utils/pagination';
import { useCrud } from '../composables/useCrud';

export default () => ({
  ...useCrud({ api: jenisSuratApi, mapper: { emptyForm, mapItemToForm }, entityName: 'Jenis Surat' }),

  templateFile: null,

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
      const payload = await kategoriSuratApi.list({ perPage: 200 });
      const { items } = normalizePaginatedResponse(payload);
      this.kategoriOptions = items.map((k) => ({
        value: k.id,
        label: `${k.kode_kategori_surat} - ${k.nama_kategori_surat}`,
      }));
    } catch {
      this.kategoriOptions = [];
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
      this.$store.notify.show('Kategori surat wajib dipilih.', 'error');
      return;
    }
    if (!isRequired(this.form.kode_jenis_surat)) {
      this.$store.notify.show('Kode jenis surat wajib diisi.', 'error');
      return;
    }
    if (!isRequired(this.form.nama_jenis_surat)) {
      this.$store.notify.show('Nama jenis surat wajib diisi.', 'error');
      return;
    }

    this.saving = true;
    this.$store.notify.clear();

    try {
      const isEdit = !!this.editingId;

      if (isEdit) {
        await jenisSuratApi.update(this.editingId, this.form, this.templateFile);
      } else {
        await jenisSuratApi.create(this.form, this.templateFile);
      }

      this.$store.notify.show(isEdit
        ? 'Data jenis surat berhasil diperbarui.'
        : 'Data jenis surat berhasil ditambahkan.', 'success');
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal menyimpan data jenis surat.', 'error');
    } finally {
      this.saving = false;
    }
  },

  openPreview(url) {
    if (!url) {
      this.$store.notify.show('Tidak ada file template PDF untuk ditampilkan.', 'error');
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