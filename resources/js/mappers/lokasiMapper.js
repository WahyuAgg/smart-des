export function emptyForm() {
  return {
    nama: '',
    keterangan: '',
  };
}

export function mapItemToForm(item) {
  return {
    nama: item.nama ?? '',
    keterangan: item.keterangan ?? '',
  };
}

export function buildPayload(form) {
  return {
    nama: String(form.nama || '').trim(),
    keterangan: String(form.keterangan || '').trim() || null,
  };
}