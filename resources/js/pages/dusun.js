import { isRequired } from '../utils/validation';
import { dusunApi } from '../services/dusunApi';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/dusunMapper';

export default () => ({
  ...useCrud({ api: dusunApi, mapper, entityName: 'Data dusun' }),

  async init() {
    await this.load();
  },

  validate(form) {
    if (!isRequired(form.nama)) return 'Nama dusun wajib diisi.';
    return null;
  },
});