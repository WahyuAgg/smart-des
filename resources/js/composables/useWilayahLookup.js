import { wilayahApi } from '../services/wilayahApi';
import { UnauthorizedError } from '../services/httpClient';

function normalizeLabel(value) {
  return String(value || '').trim().toLowerCase();
}

export function useWilayahLookup() {
  return {
    provinsiCode: '',
    kabupatenCode: '',
    kecamatanCode: '',
    desaCode: '',

    provinsiOptions: [],
    kabupatenOptions: [],
    kecamatanOptions: [],
    desaOptions: [],

    provinsiLoading: false,
    kabupatenLoading: false,
    kecamatanLoading: false,
    desaLoading: false,

    async loadProvinsiOptions() {
      this.provinsiLoading = true;

      try {
        this.provinsiOptions = await wilayahApi.list('provinsi');
        return this.provinsiOptions;
      } catch (error) {
        if (error instanceof UnauthorizedError) return [];
        this.error = error.message || 'Gagal memuat data provinsi.';
        return [];
      } finally {
        this.provinsiLoading = false;
      }
    },

    async loadKabupatenOptions() {
      if (!this.provinsiCode) {
        this.kabupatenOptions = [];
        return [];
      }

      this.kabupatenLoading = true;

      try {
        this.kabupatenOptions = await wilayahApi.list('kabupaten', { parent: this.provinsiCode });
        return this.kabupatenOptions;
      } catch (error) {
        if (error instanceof UnauthorizedError) return [];
        this.error = error.message || 'Gagal memuat data kabupaten.';
        return [];
      } finally {
        this.kabupatenLoading = false;
      }
    },

    async loadKecamatanOptions() {
      if (!this.kabupatenCode) {
        this.kecamatanOptions = [];
        return [];
      }

      this.kecamatanLoading = true;

      try {
        this.kecamatanOptions = await wilayahApi.list('kecamatan', { parent: this.kabupatenCode });
        return this.kecamatanOptions;
      } catch (error) {
        if (error instanceof UnauthorizedError) return [];
        this.error = error.message || 'Gagal memuat data kecamatan.';
        return [];
      } finally {
        this.kecamatanLoading = false;
      }
    },

    async loadDesaOptions() {
      if (!this.kecamatanCode) {
        this.desaOptions = [];
        return [];
      }

      this.desaLoading = true;

      try {
        this.desaOptions = await wilayahApi.list('desa', { parent: this.kecamatanCode });
        return this.desaOptions;
      } catch (error) {
        if (error instanceof UnauthorizedError) return [];
        this.error = error.message || 'Gagal memuat data desa.';
        return [];
      } finally {
        this.desaLoading = false;
      }
    },

    resetWilayahState() {
      this.provinsiCode = '';
      this.kabupatenCode = '';
      this.kecamatanCode = '';
      this.desaCode = '';

      this.kabupatenOptions = [];
      this.kecamatanOptions = [];
      this.desaOptions = [];
    },

    /**
     * HACK: Karena data wilayah dari API (Laravolt/Indonesia) kadang tidak konsisten
     * dengan data yang tersimpan di DB (misal "Jawa Tengah" vs "Jawa Tengah "),
     * syncWilayahSelection mencocokkan label secara case-insensitive & trim.
     *
     * Jika tetap gagal cocok, form.alamat.provinsi dkk tetap berisi nilai lama.
     * Fallback visual ditangani di Blade (option placeholder dinamis).
     */
    async syncWilayahSelection() {
      this.resetWilayahState();

      const provinsiLabel = normalizeLabel(this.form.alamat.provinsi);
      if (!provinsiLabel) return;

      await this.loadProvinsiOptions();

      const provinsi = this.provinsiOptions.find((option) => normalizeLabel(option.label) === provinsiLabel);
      if (!provinsi) return;

      this.provinsiCode = provinsi.value;
      this.form.alamat.provinsi = provinsi.label;

      const kabupatenLabel = normalizeLabel(this.form.alamat.kabupaten);
      await this.loadKabupatenOptions();

      if (!kabupatenLabel) return;

      const kabupaten = this.kabupatenOptions.find((option) => normalizeLabel(option.label) === kabupatenLabel);
      if (!kabupaten) return;

      this.kabupatenCode = kabupaten.value;
      this.form.alamat.kabupaten = kabupaten.label;

      const kecamatanLabel = normalizeLabel(this.form.alamat.kecamatan);
      await this.loadKecamatanOptions();

      if (!kecamatanLabel) return;

      const kecamatan = this.kecamatanOptions.find((option) => normalizeLabel(option.label) === kecamatanLabel);
      if (!kecamatan) return;

      this.kecamatanCode = kecamatan.value;
      this.form.alamat.kecamatan = kecamatan.label;

      const desaLabel = normalizeLabel(this.form.alamat.desa);
      await this.loadDesaOptions();

      if (!desaLabel) return;

      const desa = this.desaOptions.find((option) => normalizeLabel(option.label) === desaLabel);
      if (!desa) return;

      this.desaCode = desa.value;
      this.form.alamat.desa = desa.label;
    },

    async onProvinsiChange() {
      const selected = this.provinsiOptions.find((option) => option.value === this.provinsiCode);

      this.form.alamat.provinsi = selected?.label || '';
      this.form.alamat.kabupaten = '';
      this.form.alamat.kecamatan = '';
      this.form.alamat.desa = '';

      this.kabupatenCode = '';
      this.kecamatanCode = '';
      this.desaCode = '';
      this.kabupatenOptions = [];
      this.kecamatanOptions = [];
      this.desaOptions = [];

      await this.loadKabupatenOptions();
    },

    async onKabupatenChange() {
      const selected = this.kabupatenOptions.find((option) => option.value === this.kabupatenCode);

      this.form.alamat.kabupaten = selected?.label || '';
      this.form.alamat.kecamatan = '';
      this.form.alamat.desa = '';

      this.kecamatanCode = '';
      this.desaCode = '';
      this.kecamatanOptions = [];
      this.desaOptions = [];

      await this.loadKecamatanOptions();
    },

    async onKecamatanChange() {
      const selected = this.kecamatanOptions.find((option) => option.value === this.kecamatanCode);

      this.form.alamat.kecamatan = selected?.label || '';
      this.form.alamat.desa = '';

      this.desaCode = '';
      this.desaOptions = [];

      await this.loadDesaOptions();
    },

    onDesaChange() {
      const selected = this.desaOptions.find((option) => option.value === this.desaCode);
      this.form.alamat.desa = selected?.label || '';
    },
  };
}