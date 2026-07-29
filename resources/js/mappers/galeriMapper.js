export function emptyForm() {
  return {
    judul: '',
    deskripsi: '',
    tanggal: '',
    is_published: true,
    file: null,
  };
}

export function mapItemToForm(item) {
  return {
    judul: item.judul ?? '',
    deskripsi: item.deskripsi ?? '',
    tanggal: item.tanggal ? item.tanggal.substring(0, 10) : '',
    is_published: item.is_published ?? true,
    file: null,
  };
}

export function buildFormData(form) {
  const fd = new FormData();

  fd.append('judul', form.judul || '');
  if (form.deskripsi) fd.append('deskripsi', form.deskripsi);
  if (form.tanggal) fd.append('tanggal', form.tanggal);
  fd.append('is_published', form.is_published ? '1' : '0');

  if (form.file instanceof File) fd.append('file', form.file);

  return fd;
}