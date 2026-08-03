import { isRequired } from '../utils/validation';
import { pendidikanApi } from '../services/pendidikanApi';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/pendidikanMapper';

export default () => ({
  ...useCrud({ api: pendidikanApi, mapper, entityName: 'Data pendidikan' }),

  async init() {
    await this.load();
  },

  validate(form) {
    if (!isRequired(form.tingkat_pendidikan)) return 'Tingkat pendidikan wajib diisi.';
    return null;
  },
});