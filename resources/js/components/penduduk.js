import { Auth } from '../services/auth';
import { isRequired } from '../utils/validation';

export default () => ({
  baseUrl: window.API_BASE_URL || '/api',
  endpoint: 'penduduk',

  loading: false,
  saving: false,
  error: null,
  success: null,
  search: '',

  items: [],
  meta: { current_page: 1, last_page: 1, total: 0 },

  showModal: false,
  editingId: null,
  form: emptyForm(),

  confirmShow: false,
  deletingItem: null,

  async init() {
    if (!Auth.requireAuth()) return;
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const params = new URLSearchParams({
        page,
        search: this.search || '',
      });

      const response = await fetch(`${this.baseUrl}/${this.endpoint}?${params.toString()}`, {
        headers: Auth.headers(),
      });

      if (Auth.handleUnauthorized(response)) return;

      const json = await response.json();
      if (!response.ok || (json.success !== undefined && !json.success)) {
        throw new Error(json.message || 'Gagal memuat data penduduk.');
      }

      const payload = json.data ?? json;
      this.items = payload.data ?? payload;
      this.meta = {
        current_page: payload.current_page ?? 1,
        last_page: payload.last_page ?? 1,
        total: payload.total ?? this.items.length,
      };
    } catch (error) {
      this.error = error.message || 'Gagal memuat data penduduk.';
    } finally {
      this.loading = false;
    }
  },

  openCreate() {
    this.editingId = null;
    this.form = emptyForm();
    this.showModal = true;
  },

  openEdit(item) {
    this.editingId = item.id;
    this.form = mapItemToForm(item);
    this.showModal = true;
  },

  async save() {
    if (!isRequired(this.form.nik) || !isRequired(this.form.nama_lengkap)) {
      this.error = 'NIK dan nama lengkap wajib diisi.';
      return;
    }

    this.saving = true;
    this.error = null;

    try {
      const isEdit = !!this.editingId;
      const response = await fetch(
        isEdit ? `${this.baseUrl}/${this.endpoint}/${this.editingId}` : `${this.baseUrl}/${this.endpoint}`,
        {
          method: isEdit ? 'PUT' : 'POST',
          headers: Auth.headers({ 'Content-Type': 'application/json' }),
          body: JSON.stringify(buildPayload(this.form)),
        }
      );

      if (Auth.handleUnauthorized(response)) return;

      const json = await response.json();
      if (!response.ok || (json.success !== undefined && !json.success)) {
        throw new Error(json.message || 'Gagal menyimpan data penduduk.');
      }

      this.success = isEdit
        ? 'Data penduduk berhasil diperbarui.'
        : 'Data penduduk berhasil ditambahkan.';
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      this.error = error.message || 'Gagal menyimpan data penduduk.';
    } finally {
      this.saving = false;
    }
  },

  openDelete(item) {
    this.deletingItem = item;
    this.confirmShow = true;
  },

  async remove() {
    if (!this.deletingItem) return;

    this.loading = true;
    this.error = null;

    try {
      const response = await fetch(`${this.baseUrl}/${this.endpoint}/${this.deletingItem.id}`, {
        method: 'DELETE',
        headers: Auth.headers(),
      });

      if (Auth.handleUnauthorized(response)) return;

      const json = await response.json().catch(() => ({}));
      if (!response.ok || (json.success !== undefined && !json.success)) {
        throw new Error(json.message || 'Gagal menghapus data penduduk.');
      }

      this.success = 'Data penduduk berhasil dihapus.';
      this.confirmShow = false;
      this.deletingItem = null;
      await this.load(this.meta.current_page);
    } catch (error) {
      this.error = error.message || 'Gagal menghapus data penduduk.';
    } finally {
      this.loading = false;
    }
  },

  genderLabel(value) {
    return value || '—';
  },

  statusBadge(status) {
    return status === 'MENINGGAL'
      ? 'bg-rose-100 text-rose-700'
      : 'bg-emerald-100 text-emerald-700';
  },

  statusLabel(status) {
    return status === 'MENINGGAL' ? 'Meninggal' : 'Hidup';
  },

  formatDate(value) {
    if (!value) return '—';

    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return value;

    return new Intl.DateTimeFormat('id-ID', {
      day: '2-digit',
      month: 'short',
      year: 'numeric',
      timeZone: 'UTC',
    }).format(date);
  },
});

function emptyAddressForm() {
  return {
    label_alamat: 'Rumah',
    is_utama: true,
    alamat_lengkap: '',
    jalan: '',
    gedung_perumahan: '',
    nomor_rumah: '',
    blok: '',
    no_lantai: '',
    no_unit: '',
    rt: '',
    rw: '',
    desa: '',
    dusun: '',
    kecamatan: '',
    kabupaten: '',
    provinsi: '',
    negara: 'Indonesia',
    kode_pos: '',
    patokan: '',
    latitude: '',
    longitude: '',
  };
}

function emptyForm() {
  return {
    nik: '',
    nama_lengkap: '',
    kk_id: '',
    nama_ayah_kandung: '',
    nama_ibu_kandung: '',
    jenis_kelamin: 'Laki-laki',
    tanggal_lahir: '',
    tempat_lahir: '',
    agama: 'ISLAM',
    pekerjaan: '',
    status_perkawinan: '',
    kewarganegaraan: 'Indonesia',
    golongan_darah: '',
    no_hp: '',
    email: '',
    status_hidup: 'HIDUP',
    tanggal_meninggal: '',
    pendidikan_id: '',
    alamat: emptyAddressForm(),
  };
}

function mapItemToForm(item) {
  return {
    ...emptyForm(),
    nik: item.nik ?? '',
    nama_lengkap: item.nama_lengkap ?? '',
    kk_id: item.kk_id ?? '',
    nama_ayah_kandung: item.nama_ayah_kandung ?? '',
    nama_ibu_kandung: item.nama_ibu_kandung ?? '',
    jenis_kelamin: item.jenis_kelamin ?? 'Laki-laki',
    tanggal_lahir: dateToInputValue(item.tanggal_lahir),
    tempat_lahir: item.tempat_lahir ?? '',
    agama: item.agama ?? 'ISLAM',
    pekerjaan: item.pekerjaan ?? '',
    status_perkawinan: item.status_perkawinan ?? '',
    kewarganegaraan: item.kewarganegaraan ?? 'Indonesia',
    golongan_darah: item.golongan_darah ?? '',
    no_hp: item.no_hp ?? '',
    email: item.email ?? '',
    status_hidup: item.status_hidup ?? 'HIDUP',
    tanggal_meninggal: dateToInputValue(item.tanggal_meninggal),
    pendidikan_id: item.pendidikan_id ?? '',
    alamat: {
      ...emptyAddressForm(),
      ...(item.alamat ?? {}),
      is_utama: Boolean(item.alamat?.is_utama),
    },
  };
}

function buildPayload(form) {
  return {
    nik: form.nik,
    nama_lengkap: form.nama_lengkap,
    kk_id: toNullableNumber(form.kk_id),
    nama_ayah_kandung: form.nama_ayah_kandung || null,
    nama_ibu_kandung: form.nama_ibu_kandung || null,
    jenis_kelamin: form.jenis_kelamin || null,
    tanggal_lahir: form.tanggal_lahir || null,
    tempat_lahir: form.tempat_lahir || null,
    agama: form.agama || null,
    pekerjaan: form.pekerjaan || null,
    status_perkawinan: form.status_perkawinan || null,
    kewarganegaraan: form.kewarganegaraan || null,
    golongan_darah: form.golongan_darah || null,
    no_hp: form.no_hp || null,
    email: form.email || null,
    status_hidup: form.status_hidup || 'HIDUP',
    tanggal_meninggal: form.status_hidup === 'MENINGGAL' ? form.tanggal_meninggal || null : null,
    pendidikan_id: toNullableNumber(form.pendidikan_id),
    alamat: {
      ...form.alamat,
      is_utama: form.alamat.is_utama ? 1 : 0,
    },
  };
}

function toNullableNumber(value) {
  if (value === '' || value === null || value === undefined) return null;

  const number = Number(value);
  return Number.isNaN(number) ? null : number;
}

function dateToInputValue(value) {
  if (!value) return '';

  const date = new Date(value);
  if (Number.isNaN(date.getTime())) return '';

  return date.toISOString().slice(0, 10);
}