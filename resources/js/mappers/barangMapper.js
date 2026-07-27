export function emptyForm() {
  return {
    kode_barang: '',
    nama_barang: '',
    kategori_id: '',
    lokasi_id: '',
    satuan: '',
    tanggal_perolehan: '',
    keterangan: '',
    jumlah_total: '',
  };
}

export function mapItemToForm(item) {
  return {
    kode_barang: item.kode_barang ?? '',
    nama_barang: item.nama_barang ?? '',
    kategori_id: item.kategori_id ?? '',
    lokasi_id: item.lokasi_id ?? '',
    satuan: item.satuan ?? '',
    tanggal_perolehan: item.tanggal_perolehan ?? '',
    keterangan: item.keterangan ?? '',
    jumlah_total: item.jumlah_total ?? '',
  };
}

export function buildPayload(form) {
  return {
    kode_barang: String(form.kode_barang || '').trim(),
    nama_barang: String(form.nama_barang || '').trim(),
    kategori_id: form.kategori_id ? Number(form.kategori_id) : null,
    lokasi_id: form.lokasi_id ? Number(form.lokasi_id) : null,
    satuan: String(form.satuan || '').trim(),
    tanggal_perolehan: form.tanggal_perolehan || null,
    keterangan: String(form.keterangan || '').trim() || null,
    jumlah_total: form.jumlah_total ? Number(form.jumlah_total) : 0,
  };
}