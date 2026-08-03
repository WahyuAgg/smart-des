import { isRequired } from '../utils/validation';
import { kategoriBarangApi } from '../services/kategoriBarangApi';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/kategoriBarangMapper';

export default () => ({
  ...useCrud({ api: kategoriBarangApi, mapper, entityName: 'Kategori barang' }),

  async init() {
    await this.load();
  },

  validate(form) {
    if (!isRequired(form.nama)) return 'Nama kategori wajib diisi.';
    return null;
  },
});