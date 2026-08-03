import { isRequired } from '../utils/validation';
import { jabatanPerangkatApi } from '../services/jabatanPerangkatApi';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/jabatanPerangkatMapper';

export default () => ({
  ...useCrud({ api: jabatanPerangkatApi, mapper, entityName: 'Data jabatan' }),

  async init() {
    await this.load();
  },

  validate(form) {
    if (!isRequired(form.kode)) return 'Kode jabatan wajib diisi.';
    if (!isRequired(form.nama)) return 'Nama jabatan wajib diisi.';
    return null;
  },
});