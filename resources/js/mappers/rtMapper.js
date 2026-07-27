export function emptyForm() {
  return {
    rw_id: '',
    nomor_rt: '',
    ketua_rt: '',
  };
}

export function mapItemToForm(item) {
  return {
    rw_id: item.rw_id ?? '',
    nomor_rt: item.nomor_rt ?? '',
    ketua_rt: item.ketua_rt ?? '',
  };
}

export function buildPayload(form) {
  return {
    rw_id: Number(form.rw_id) || null,
    nomor_rt: String(form.nomor_rt || '').trim(),
    ketua_rt: String(form.ketua_rt || '').trim() || null,
  };
}