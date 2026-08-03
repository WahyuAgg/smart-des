import { galeriApi } from '../services/galeriApi';
import { useCrud } from '../composables/useCrud';
import { emptyForm, mapItemToForm, buildFormData } from '../mappers/galeriMapper';

export default () => ({
  ...useCrud({
    api: galeriApi,
    mapper: { emptyForm, mapItemToForm, buildFormData },
    entityName: 'Galeri',
  }),

  async init() {
    await this.load();
  },

  onFileChange(event) {
    const file = event.target?.files?.[0] || null;
    this.form.file = file;
  },
});