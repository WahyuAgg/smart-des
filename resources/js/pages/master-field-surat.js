import { isRequired } from '../utils/validation';
import { masterFieldSuratApi } from '../services/masterFieldSuratApi';
import { UnauthorizedError } from '../services/httpClient';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/masterFieldSuratMapper';
import { inputModeLabel, inputModeBadge } from '../utils/inputMode';

export default () => ({
  ...useCrud({
    api: masterFieldSuratApi,
    mapper,
    entityName: 'Field surat',
    loadOptions: { tipe: '', input_mode: '', source: '' },
  }),

  filterTipe: '',
  filterInputMode: '',
  filterSource: '',

  async init() {
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.$store.notify.clear();

    try {
      const { items, meta } = await masterFieldSuratApi.list({
        page,
        search: this.search,
        tipe: this.filterTipe,
        input_mode: this.filterInputMode,
        source: this.filterSource,
      });
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal memuat data field surat.', 'error');
    } finally {
      this.loading = false;
    }
  },

  copyPlaceholder(name) {
    navigator.clipboard.writeText(`\${${name}}`);
    this.$store.notify.show('Placeholder berhasil disalin.', 'success');
  },

  validate(form) {
    if (!isRequired(form.nama) || !isRequired(form.label) || !isRequired(form.input_mode) || !isRequired(form.tipe)) {
      return 'Nama, label, tipe, dan input mode wajib diisi.';
    }
    return null;
  },

  inputModeLabel,
  inputModeBadge,
});
