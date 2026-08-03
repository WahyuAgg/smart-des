import { profilDesaApi } from '../services/profilDesaApi';
import { UnauthorizedError } from '../services/httpClient';

/**
 * Initial empty form state.
 */
export function emptyForm() {
  return {
    nama: '',
    kode: '',
    kode_pos: '',
    alamat: '',
    telepon: '',
    email: '',
    website: '',
    visi: '',
    misi: [],
    deskripsi: '',

    // File uploads (will be File objects or null)
    logo: null,
    peta_pdf: null,

    // Wilayah
    nama_provinsi: '',
    nama_kabupaten: '',
    nama_kecamatan: '',
    nama_desa: '',

    // Profil Kecamatan
    profil_kecamatan: {
      camat: '',
      nip: '',
      telepon: '',
      email: '',
      foto: null,
      tanda_tangan: null,
    },
  };
}

/**
 * Map an API item to the form structure.
 */
export function mapItemToForm(item) {
  const kec = item.profil_kecamatan || {};
  return {
    nama: item.nama ?? '',
    kode: item.kode ?? '',
    kode_pos: item.kode_pos ?? '',
    alamat: item.alamat ?? '',
    telepon: item.telepon ?? '',
    email: item.email ?? '',
    website: item.website ?? '',
    visi: item.visi ?? '',
    misi: Array.isArray(item.misi) ? [...item.misi] : [],
    deskripsi: item.deskripsi ?? '',

    logo: null, // File objects are not preserved from API
    peta_pdf: null,

    nama_provinsi: item.nama_provinsi ?? '',
    nama_kabupaten: item.nama_kabupaten ?? '',
    nama_kecamatan: item.nama_kecamatan ?? '',
    nama_desa: item.nama_desa ?? '',

    profil_kecamatan: {
      camat: kec.camat ?? '',
      nip: kec.nip ?? '',
      telepon: kec.telepon ?? '',
      email: kec.email ?? '',
      foto: null,
      tanda_tangan: null,
    },
  };
}

/**
 * Build a FormData payload from form state.
 */
export function buildFormData(form) {
  const fd = new FormData();

  fd.append('nama', form.nama || '');
  if (form.kode) fd.append('kode', form.kode);
  if (form.kode_pos) fd.append('kode_pos', form.kode_pos);
  if (form.alamat) fd.append('alamat', form.alamat);
  if (form.telepon) fd.append('telepon', form.telepon);
  if (form.email) fd.append('email', form.email);
  if (form.website) fd.append('website', form.website);
  if (form.visi) fd.append('visi', form.visi);

  // Misi: array of strings
  if (Array.isArray(form.misi)) {
    form.misi.forEach((item, i) => {
      fd.append(`misi[${i}]`, item);
    });
  }

  if (form.deskripsi) fd.append('deskripsi', form.deskripsi);

  // File uploads
  if (form.logo instanceof File) {
    fd.append('logo', form.logo);
  }
  if (form.peta_pdf instanceof File) {
    fd.append('peta_pdf', form.peta_pdf);
  }

  // Wilayah
  if (form.nama_provinsi) fd.append('nama_provinsi', form.nama_provinsi);
  if (form.nama_kabupaten) fd.append('nama_kabupaten', form.nama_kabupaten);
  if (form.nama_kecamatan) fd.append('nama_kecamatan', form.nama_kecamatan);
  if (form.nama_desa) fd.append('nama_desa', form.nama_desa);

  // Profil Kecamatan
  const kec = form.profil_kecamatan || {};
  if (kec.camat) fd.append('profil_kecamatan[camat]', kec.camat);
  if (kec.nip) fd.append('profil_kecamatan[nip]', kec.nip);
  if (kec.telepon) fd.append('profil_kecamatan[telepon]', kec.telepon);
  if (kec.email) fd.append('profil_kecamatan[email]', kec.email);
  if (kec.foto instanceof File) {
    fd.append('profil_kecamatan[foto]', kec.foto);
  }
  if (kec.tanda_tangan instanceof File) {
    fd.append('profil_kecamatan[tanda_tangan]', kec.tanda_tangan);
  }

  return fd;
}

/**
 * Alpine component for Profil Desa CRUD (single-record).
 */
export default () => ({
  loading: false,
  saving: false,
  deleting: false,

  // Data
  record: null,
  form: emptyForm(),

  // UI state
  isEditing: false,
  confirmDelete: false,

  // Existing file URLs (for display)
  existingLogoUrl: null,
  existingPetaPdfUrl: null,
  existingFotoUrl: null,
  existingTandaTanganUrl: null,

  async init() {
    await this.load();
  },

  async load() {
    this.loading = true;
    this.$store.notify.clear();

    try {
      this.record = await profilDesaApi.get();
      this.form = mapItemToForm(this.record);
      this.updateMediaUrls();
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      // If 404 / no data, it's fine — user can create
      if (error.message?.toLowerCase().includes('not found') || error.message?.toLowerCase().includes('no result')) {
        this.record = null;
        this.form = emptyForm();
        return;
      }
      this.$store.notify.show(error.message || 'Gagal memuat data profil desa.', 'error');
    } finally {
      this.loading = false;
    }
  },

  updateMediaUrls() {
    if (!this.record) {
      this.existingLogoUrl = null;
      this.existingPetaPdfUrl = null;
      this.existingFotoUrl = null;
      this.existingTandaTanganUrl = null;
      return;
    }

    const resolveUrl = (path, explicitUrl = null) => {
      if (explicitUrl) return explicitUrl;
      if (!path) return null;
      if (typeof path !== 'string') return null;
      if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) return path;
      return `/storage/${path}`;
    };

    this.existingLogoUrl = resolveUrl(this.record.logo, this.record.logo_url);
    this.existingPetaPdfUrl = resolveUrl(this.record.peta_pdf, this.record.peta_pdf_url);
    this.existingFotoUrl = resolveUrl(this.record.profil_kecamatan?.foto);
    this.existingTandaTanganUrl = resolveUrl(this.record.profil_kecamatan?.tanda_tangan);
  },

  openCreate() {
    this.isEditing = true;
    this.form = emptyForm();
    this.existingLogoUrl = null;
    this.existingPetaPdfUrl = null;
    this.existingFotoUrl = null;
    this.existingTandaTanganUrl = null;
  },

  openEdit() {
    this.isEditing = true;
    this.form = mapItemToForm(this.record);
    this.updateMediaUrls();
  },

  cancelEdit() {
    this.isEditing = false;
    this.form = this.record ? mapItemToForm(this.record) : emptyForm();
    this.$store.notify.clear();
  },

  async save() {
    this.saving = true;
    this.$store.notify.clear();

    try {
      const fd = buildFormData(this.form);

      if (this.record) {
        await profilDesaApi.update(fd);
        this.$store.notify.show('Profil desa berhasil diperbarui.', 'success');
      } else {
        await profilDesaApi.create(fd);
        this.$store.notify.show('Profil desa berhasil ditambahkan.', 'success');
      }

      this.isEditing = false;
      await this.load();
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal menyimpan data.', 'error');
    } finally {
      this.saving = false;
    }
  },

  openDelete() {
    this.confirmDelete = true;
  },

  async remove() {
    this.deleting = true;
    this.$store.notify.clear();

    try {
      await profilDesaApi.remove();
      this.$store.notify.show('Profil desa berhasil dihapus.', 'success');
      this.confirmDelete = false;
      this.record = null;
      this.form = emptyForm();
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal menghapus data.', 'error');
    } finally {
      this.deleting = false;
    }
  },

  /**
   * Handle file input change.
   * @param {string} field - dot-separated path, e.g. 'logo' or 'profil_kecamatan.foto'
   * @param {Event} event
   */
  onFileChange(field, event) {
    const file = event.target?.files?.[0] || null;
    if (field.includes('.')) {
      const [parent, key] = field.split('.');
      this.form[parent][key] = file;
    } else {
      this.form[field] = file;
    }
  },

  addMisi() {
    this.form.misi.push('');
  },

  removeMisi(index) {
    this.form.misi.splice(index, 1);
  },
});