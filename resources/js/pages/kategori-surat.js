import { isRequired } from '../utils/validation';
import { kategoriSuratApi } from '../services/kategoriSuratApi';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/kategoriSuratMapper';

export default () => ({
  ...useCrud({ api: kategoriSuratApi, mapper, entityName: 'Data kategori surat' }),

  async init() {
    await this.load();
  },

  validate(form) {
    if (!isRequired(form.kode_kategori_surat)) return 'Kode kategori surat wajib diisi.';
    if (!isRequired(form.nama_kategori_surat)) return 'Nama kategori surat wajib diisi.';
    return null;
  },
});