export function emptyForm() {
  return {
    nama: '',
    kepala_dusun: '',
  };
}

export function mapItemToForm(item) {
  return {
    nama: item.nama ?? '',
    kepala_dusun: item.kepala_dusun ?? '',
  };
}

export function buildPayload(form) {
  return {
    nama: String(form.nama || '').trim(),
    kepala_dusun: String(form.kepala_dusun || '').trim() || null,
  };
}