export function emptyForm() {
  return {
    nama_peminjam: '',
    tanggal_pinjam: new Date().toISOString().split('T')[0],
    tanggal_rencana_kembali: '',
    keterangan: '',
    details: [{ barang_id: '', jumlah: '' }],
  };
}

export function mapItemToForm(item) {
  return {
    nama_peminjam: item.nama_peminjam ?? '',
    tanggal_pinjam: item.tanggal_pinjam ?? '',
    tanggal_rencana_kembali: item.tanggal_rencana_kembali ?? '',
    keterangan: item.keterangan ?? '',
    details: item.details?.length
      ? item.details.map(d => ({ barang_id: d.barang_id ?? '', jumlah: d.jumlah_pinjam ?? '' }))
      : [{ barang_id: '', jumlah: '' }],
  };
}

export function buildPayload(form) {
  return {
    nama_peminjam: String(form.nama_peminjam || '').trim(),
    tanggal_pinjam: form.tanggal_pinjam || null,
    tanggal_rencana_kembali: form.tanggal_rencana_kembali || null,
    keterangan: String(form.keterangan || '').trim() || null,
    details: form.details
      .filter(d => d.barang_id && d.jumlah)
      .map(d => ({
        barang_id: Number(d.barang_id),
        jumlah: Number(d.jumlah),
      })),
  };
}