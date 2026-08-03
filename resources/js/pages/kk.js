import { isRequired } from '../utils/validation';
import { kkApi } from '../services/kkApi';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/kkMapper';

export default () => ({
  ...useCrud({ api: kkApi, mapper, entityName: 'Data KK' }),

  async init() {
    await this.load();
  },

  validate(form) {
    if (!isRequired(form.no_kk)) return 'Nomor KK wajib diisi.';
    return null;
  },

  kkStatusBadge(nikKepalaKeluarga) {
    return isRequired(nikKepalaKeluarga)
      ? 'bg-emerald-100 text-emerald-700'
      : 'bg-amber-100 text-amber-700';
  },

  kkStatusLabel(nikKepalaKeluarga) {
    return isRequired(nikKepalaKeluarga) ? 'Lengkap' : 'Belum diisi';
  },
});