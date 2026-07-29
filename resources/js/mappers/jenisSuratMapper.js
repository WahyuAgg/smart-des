export function emptyForm() {
  return {
    kategori_surat_id: '',
    kode_jenis_surat: '',
    nama_jenis_surat: '',
    deskripsi: '',
    is_active: true,
    penduduk_fields: [],
  };
}

export function mapItemToForm(item) {
  return {
    kategori_surat_id: item.kategori_surat_id ?? '',
    kode_jenis_surat: item.kode_jenis_surat ?? '',
    nama_jenis_surat: item.nama_jenis_surat ?? '',
    deskripsi: item.deskripsi ?? '',
    is_active: item.is_active ?? true,
    penduduk_fields: (item.srt_jenis_surat_penduduks || []).map((f, i) => ({
      temp_id: `field_${i}`,
      id: f.id ?? null,
      urutan: f.urutan ?? i + 1,
      kode: f.kode ?? '',
      label: f.label ?? '',
      deskripsi: f.deskripsi ?? '',
      wajib: f.wajib ?? false,
    })),
  };
}

/**
 * Build payload as a plain object (for JSON).
 * For multipart upload, convert to FormData separately.
 */
export function buildPayload(form) {
  return {
    kategori_surat_id: Number(form.kategori_surat_id) || null,
    kode_jenis_surat: String(form.kode_jenis_surat || '').trim(),
    nama_jenis_surat: String(form.nama_jenis_surat || '').trim(),
    deskripsi: String(form.deskripsi || '').trim() || null,
    is_active: Boolean(form.is_active),
    penduduk_fields: (form.penduduk_fields || []).map((f, i) => ({
      urutan: i + 1,
      kode: String(f.kode || '').trim(),
      label: String(f.label || '').trim(),
      deskripsi: String(f.deskripsi || '').trim() || null,
      wajib: Boolean(f.wajib),
    })),
  };
}

/**
 * Build FormData for multipart upload (create/update with file).
 */
export function buildFormData(form, templateFile = null) {
  const fd = new FormData();

  fd.append('kategori_surat_id', String(Number(form.kategori_surat_id) || ''));
  fd.append('kode_jenis_surat', String(form.kode_jenis_surat || '').trim());
  fd.append('nama_jenis_surat', String(form.nama_jenis_surat || '').trim());
  fd.append('deskripsi', String(form.deskripsi || '').trim() || '');
  fd.append('is_active', form.is_active ? '1' : '0');

  if (templateFile) {
    fd.append('template', templateFile);
  }

  (form.penduduk_fields || []).forEach((f, i) => {
    fd.append(`penduduk_fields[${i}][urutan]`, String(i + 1));
    fd.append(`penduduk_fields[${i}][kode]`, String(f.kode || '').trim());
    fd.append(`penduduk_fields[${i}][label]`, String(f.label || '').trim());
    fd.append(`penduduk_fields[${i}][deskripsi]`, String(f.deskripsi || '').trim());
    fd.append(`penduduk_fields[${i}][wajib]`, f.wajib ? '1' : '0');
  });

  return fd;
}