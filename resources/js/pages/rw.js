import { isRequired } from '../utils/validation';
import { rwApi } from '../services/rwApi';
import { dusunApi } from '../services/dusunApi';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/rwMapper';

export default () => ({
  ...useCrud({ api: rwApi, mapper, entityName: 'Data RW' }),

  dusunList: [],

  async init() {
    await this.loadDusun();
    await this.load();
  },

  async loadDusun() {
    try {
      this.dusunList = await dusunApi.listAll();
    } catch { this.dusunList = []; }
  },

  validate(form) {
    if (!isRequired(form.dusun_id)) return 'Dusun wajib dipilih.';
    if (!isRequired(form.nomor_rw)) return 'Nomor RW wajib diisi.';
    return null;
  },

  dusunName(dusunId) {
    const d = this.dusunList.find(d => d.id === dusunId);
    return d ? d.nama : '—';
  },
});