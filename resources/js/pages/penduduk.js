import { isRequired } from '../utils/validation';
import { pendudukApi } from '../services/pendudukApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/pendudukMapper';
import { genderLabel, statusBadge, statusLabel } from '../utils/format';
import { useCrud } from '../composables/useCrud';
import { useKKLookup } from '../composables/useKKLookup';
import { usePendidikanLookup } from '../composables/usePendidikanLookup';
import { useWilayahLookup } from '../composables/useWilayahLookup';

export default () => ({
  ...useCrud({ api: pendudukApi, mapper: { emptyForm, mapItemToForm, buildPayload }, entityName: 'Penduduk', useNormalize: false }),

  // Detail Modal state
  detailShow: false,
  detailLoading: false,
  detailItem: null,

  // Autocomplete/lookup state & methods for KK and Pendidikan
  ...useKKLookup(),
  ...usePendidikanLookup(),
  ...useWilayahLookup(),

  async init() {
    await Promise.all([this.loadKkOptions(), this.loadPendidikanOptions(), this.loadProvinsiOptions()]);
    await this.load();
  },

  openCreate() {
    this.editingId = null;
    this.form = emptyForm();
    this.resetLookupState();
    this.resetWilayahState();
    this.showModal = true;
  },

  async openEdit(item) {
    this.editingId = item.id;
    this.form = mapItemToForm(item);
    this.syncLookupState();
    await this.syncWilayahSelection();
    this.showModal = true;
    await Promise.all([this.ensureKkSelection(), this.ensurePendidikanSelection()]);
  },

  async openDetail(item) {
    this.detailShow = true;
    this.detailLoading = true;
    this.detailItem = null;

    try {
      const data = await pendudukApi.getById(item.id);
      this.detailItem = data || item;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal memuat detail penduduk.', 'error');
      this.detailItem = item;
    } finally {
      this.detailLoading = false;
    }
  },

  async save() {
    if (!isRequired(this.form.nik) || !isRequired(this.form.nama_lengkap)) {
      this.$store.notify.show('NIK dan nama lengkap wajib diisi.', 'error');
      return;
    }

    this.saving = true;
    this.$store.notify.clear();

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await pendudukApi.update(this.editingId, payload);
      } else {
        await pendudukApi.create(payload);
      }

      this.$store.notify.show(isEdit
        ? 'Data penduduk berhasil diperbarui.'
        : 'Data penduduk berhasil ditambahkan.', 'success');
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal menyimpan data penduduk.', 'error');
    } finally {
      this.saving = false;
    }
  },

  // Display helpers used directly in the template
  genderLabel,
  statusBadge,
  statusLabel,

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
