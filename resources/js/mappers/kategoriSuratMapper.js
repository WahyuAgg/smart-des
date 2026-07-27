export function emptyForm() {
  return {
    kode_kategori_surat: '',
    nama_kategori_surat: '',
    deskripsi: '',
    is_active: true,
  };
}

export function mapItemToForm(item) {
  return {
    kode_kategori_surat: item.kode_kategori_surat ?? '',
    nama_kategori_surat: item.nama_kategori_surat ?? '',
    deskripsi: item.deskripsi ?? '',
    is_active: item.is_active ?? true,
  };
}

export function buildPayload(form) {
  return {
    kode_kategori_surat: String(form.kode_kategori_surat || '').trim(),
    nama_kategori_surat: String(form.nama_kategori_surat || '').trim(),
    deskripsi: String(form.deskripsi || '').trim() || null,
    is_active: Boolean(form.is_active),
  };
}