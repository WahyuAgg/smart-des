export function emptyForm() {
  return {
    jabatan_perangkat_id: '',
    nama: '',
    nip: '',
    telepon: '',
    email: '',
    foto: null,
    tanda_tangan: null,
    tanggal_mulai: '',
    tanggal_selesai: '',
    aktif: true,
  };
}

export function mapItemToForm(item) {
  return {
    jabatan_perangkat_id: item.jabatan_perangkat_id ?? '',
    nama: item.nama ?? '',
    nip: item.nip ?? '',
    telepon: item.telepon ?? '',
    email: item.email ?? '',
    foto: item.foto ?? null,
    tanda_tangan: item.tanda_tangan ?? null,
    tanggal_mulai: item.tanggal_mulai ?? '',
    tanggal_selesai: item.tanggal_selesai ?? '',
    aktif: item.aktif ?? true,
  };
}

export function buildPayload(form) {
  const payload = {
    jabatan_perangkat_id: Number(form.jabatan_perangkat_id) || null,
    nama: String(form.nama || '').trim(),
    nip: String(form.nip || '').trim() || null,
    telepon: String(form.telepon || '').trim() || null,
    email: String(form.email || '').trim() || null,
    foto: form.foto || null,
    tanda_tangan: form.tanda_tangan || null,
    tanggal_mulai: form.tanggal_mulai || null,
    tanggal_selesai: form.tanggal_selesai || null,
    aktif: form.aktif === true || form.aktif === 'true' || form.aktif === 1 || form.aktif === '1',
  };

  // Remove null fields to let backend handle defaults
  Object.keys(payload).forEach(key => {
    if (payload[key] === null) {
      delete payload[key];
    }
  });

  return payload;
}