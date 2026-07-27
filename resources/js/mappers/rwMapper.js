export function emptyForm() {
  return {
    dusun_id: '',
    nomor_rw: '',
    ketua_rw: '',
  };
}

export function mapItemToForm(item) {
  return {
    dusun_id: item.dusun_id ?? '',
    nomor_rw: item.nomor_rw ?? '',
    ketua_rw: item.ketua_rw ?? '',
  };
}

export function buildPayload(form) {
  return {
    dusun_id: Number(form.dusun_id) || null,
    nomor_rw: String(form.nomor_rw || '').trim(),
    ketua_rw: String(form.ketua_rw || '').trim() || null,
  };
}