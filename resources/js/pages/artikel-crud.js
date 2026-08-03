import { paperApi } from '../services/paperApi';
import { useCrud } from '../composables/useCrud';
import { emptyForm, mapItemToForm, buildFormData } from '../mappers/paperMapper';

export default () => ({
  ...useCrud({
    api: paperApi,
    mapper: { emptyForm, mapItemToForm, buildFormData },
    entityName: 'Artikel',
  }),

  async init() {
    await this.load();
  },

  onFileChange(field, event) {
    const file = event.target?.files?.[0] || null;
    this.form[field] = file;
  },
});