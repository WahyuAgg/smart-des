export function emptyForm() {
  return {
    judul: '',
    slug: '',
    ringkasan: '',
    nama_penulis: '',
    tahun: '',
    pdf: null,
    thumbnail: null,
    jumlah_halaman: '',
    status: 'draft',
  };
}

export function mapItemToForm(item) {
  return {
    judul: item.judul ?? '',
    slug: item.slug ?? '',
    ringkasan: item.ringkasan ?? '',
    nama_penulis: item.nama_penulis ?? '',
    tahun: item.tahun ?? '',
    pdf: null,
    thumbnail: null,
    jumlah_halaman: item.jumlah_halaman ?? '',
    status: item.status ?? 'draft',
  };
}

export function buildFormData(form) {
  const fd = new FormData();

  fd.append('judul', form.judul || '');
  if (form.slug) fd.append('slug', form.slug);
  if (form.ringkasan) fd.append('ringkasan', form.ringkasan);
  fd.append('nama_penulis', form.nama_penulis || '');
  if (form.tahun) fd.append('tahun', String(form.tahun));
  if (form.jumlah_halaman) fd.append('jumlah_halaman', String(form.jumlah_halaman));
  fd.append('status', form.status || 'draft');

  if (form.pdf instanceof File) fd.append('pdf', form.pdf);
  if (form.thumbnail instanceof File) fd.append('thumbnail', form.thumbnail);

  return fd;
}