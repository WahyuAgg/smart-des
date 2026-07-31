import { dateToInputValue } from '../utils/date';
import { toNullableNumber } from '../utils/number';
import { mapPaginatedResponse } from '../utils/pagination';

export { mapPaginatedResponse };

export function emptyAddressForm() {
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

export function emptyForm() {
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

export function mapItemToForm(item) {
  const address = item.alamat ?? {};

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
      label_alamat: address.label_alamat ?? item.label_alamat ?? 'Rumah',
      is_utama: Boolean(address.is_utama ?? item.is_utama),
      alamat_lengkap: address.alamat_lengkap ?? item.alamat_lengkap ?? '',
      jalan: address.jalan ?? item.jalan ?? '',
      gedung_perumahan: address.gedung_perumahan ?? item.gedung_perumahan ?? '',
      nomor_rumah: address.nomor_rumah ?? item.nomor_rumah ?? '',
      blok: address.blok ?? item.blok ?? '',
      no_lantai: address.no_lantai ?? item.no_lantai ?? '',
      no_unit: address.no_unit ?? item.no_unit ?? '',
      rt: address.rt ?? item.rt ?? '',
      rw: address.rw ?? item.rw ?? '',
      desa: address.desa ?? item.desa ?? '',
      dusun: address.dusun ?? item.dusun ?? '',
      kecamatan: address.kecamatan ?? item.kecamatan ?? '',
      kabupaten: address.kabupaten ?? item.kabupaten ?? '',
      provinsi: address.provinsi ?? item.provinsi ?? '',
      negara: address.negara ?? item.negara ?? 'Indonesia',
      kode_pos: address.kode_pos ?? item.kode_pos ?? '',
      patokan: address.patokan ?? item.patokan ?? '',
      latitude: address.latitude ?? item.latitude ?? '',
      longitude: address.longitude ?? item.longitude ?? '',
    },
  };
}

const jenisKelaminMap = {
  'Laki-laki': 'L',
  'Perempuan': 'P',
};

export function buildPayload(form) {
  return {
    nik: form.nik,
    nama_lengkap: form.nama_lengkap,
    kk_id: toNullableNumber(form.kk_id),
    nama_ayah_kandung: form.nama_ayah_kandung || null,
    nama_ibu_kandung: form.nama_ibu_kandung || null,
    jenis_kelamin: jenisKelaminMap[form.jenis_kelamin] ?? null,
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
