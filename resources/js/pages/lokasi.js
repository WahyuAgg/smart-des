import { isRequired } from '../utils/validation';
import { lokasiApi } from '../services/lokasiApi';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/lokasiMapper';

export default () => ({
  ...useCrud({ api: lokasiApi, mapper, entityName: 'Lokasi' }),

  async init() {
    await this.load();
  },

  validate(form) {
    if (!isRequired(form.nama)) return 'Nama lokasi wajib diisi.';
    return null;
  },
});