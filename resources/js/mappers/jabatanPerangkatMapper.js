export function emptyForm() {
  return {
    kode: '',
    nama: '',
    deskripsi: '',
    urutan: '',
    aktif: true,
    dapat_menandatangani: 0,
  };
}

export function mapItemToForm(item) {
  return {
    kode: item.kode ?? '',
    nama: item.nama ?? '',
    deskripsi: item.deskripsi ?? '',
    urutan: item.urutan ?? '',
    aktif: item.aktif ?? true,
    dapat_menandatangani: item.dapat_menandatangani ?? 0,
  };
}

export function buildPayload(form) {
  return {
    kode: String(form.kode || '').trim(),
    nama: String(form.nama || '').trim(),
    deskripsi: String(form.deskripsi || '').trim() || null,
    urutan: Number(form.urutan) || 0,
    aktif: form.aktif === true || form.aktif === 'true' || form.aktif === 1 || form.aktif === '1',
    dapat_menandatangani: form.dapat_menandatangani == 1 || form.dapat_menandatangani === '1' ? 1 : 0,
  };
}