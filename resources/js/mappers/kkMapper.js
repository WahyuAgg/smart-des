export function emptyForm() {
  return {
    no_kk: '',
    nik_kepala_keluarga: '',
  };
}

export function mapItemToForm(item) {
  return {
    no_kk: item.no_kk ?? '',
    nik_kepala_keluarga: item.nik_kepala_keluarga ?? '',
  };
}

export function buildPayload(form) {
  return {
    no_kk: String(form.no_kk || '').trim(),
    nik_kepala_keluarga: String(form.nik_kepala_keluarga || '').trim() || null,
  };
}