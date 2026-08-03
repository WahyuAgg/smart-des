import { isRequired } from '../utils/validation';
import { rtApi } from '../services/rtApi';
import { rwApi } from '../services/rwApi';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/rtMapper';

export default () => ({
  ...useCrud({ api: rtApi, mapper, entityName: 'Data RT' }),

  rwList: [],

  async init() {
    await this.loadRw();
    await this.load();
  },

  async loadRw() {
    try {
      this.rwList = await rwApi.listAll();
    } catch { this.rwList = []; }
  },

  validate(form) {
    if (!isRequired(form.rw_id)) return 'RW wajib dipilih.';
    if (!isRequired(form.nomor_rt)) return 'Nomor RT wajib diisi.';
    return null;
  },

  rwLabel(rwId) {
    const r = this.rwList.find(r => r.id === rwId);
    return r ? `RW ${r.nomor_rw}` : '—';
  },
});