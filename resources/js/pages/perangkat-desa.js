import { isRequired } from '../utils/validation';
import { jabatanPerangkatApi } from '../services/jabatanPerangkatApi';
import { perangkatDesaApi } from '../services/perangkatDesaApi';
import { UnauthorizedError } from '../services/httpClient';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/perangkatDesaMapper';

export default () => ({
  ...useCrud({ api: perangkatDesaApi, mapper, entityName: 'Data perangkat desa' }),

  jabatanOptions: [],

  async init() {
    await Promise.all([this.load(), this.loadJabatanOptions()]);
  },

  async loadJabatanOptions() {
    try {
      const result = await jabatanPerangkatApi.listAll();
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

  openCreateWithJabatan(jabatan) {
    this.editingId = null;
    this.form = mapper.emptyForm();
    const matched = this.jabatanOptions.find(o => o.label.startsWith(jabatan.nama));
    if (matched) {
      this.form.jabatan_perangkat_id = matched.value;
    }
    this.showModal = true;
  },

  openEdit(item) {
    if (!item.perangkat) return;
    this.editingId = item.perangkat.id;
    this.form = mapper.mapItemToForm(item.perangkat);
    this.showModal = true;
  },

  validate(form) {
    if (!isRequired(form.nama)) return 'Nama perangkat desa wajib diisi.';
    if (!isRequired(form.jabatan_perangkat_id)) return 'Jabatan perangkat wajib dipilih.';
    return null;
  },

  openDelete(item) {
    if (!item.perangkat) return;
    this.deletingItem = item;
    this.confirmShow = true;
  },

  async remove() {
    if (!this.deletingItem?.perangkat) return;
    const id = this.deletingItem.perangkat.id;
    this.loading = true;
    this.$store.notify.clear();
    try {
      await perangkatDesaApi.remove(id);
      this.$store.notify.show('Data perangkat desa berhasil dihapus.', 'success');
      this.deletingItem = null;
      this.confirmShow = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal menghapus data perangkat desa.', 'error');
    } finally {
      this.loading = false;
    }
  },
});