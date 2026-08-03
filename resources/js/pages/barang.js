import { isRequired } from '../utils/validation';
import { barangApi } from '../services/barangApi';
import { UnauthorizedError } from '../services/httpClient';
import { useCrud } from '../composables/useCrud';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/barangMapper';
import { useKategoriLookup } from '../composables/useKategoriLookup';
import { useLokasiLookup } from '../composables/useLokasiLookup';

export default () => ({
  ...useCrud({ api: barangApi, mapper: { emptyForm, mapItemToForm, buildPayload }, entityName: 'Barang' }),

  // Aksi stok
  stockAction: null, // 'pengadaan' | 'hilang' | 'ketemu' | 'opname' | 'hapus-stok'
  stockItem: null,
  stockForm: { jumlah: '', stok_fisik: '', keterangan: '' },
  stockSaving: false,

  // Lookup data
  kategoriLookup: useKategoriLookup(),
  lokasiLookup: useLokasiLookup(),

  async init() {
    await Promise.all([this.kategoriLookup.init(), this.lokasiLookup.init()]);
    await this.load();
  },

  async save() {
    if (!isRequired(this.form.nama_barang)) {
      this.$store.notify.show('Nama barang wajib diisi.', 'error');
      return;
    }

    this.saving = true;
    this.$store.notify.clear();

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await barangApi.update(this.editingId, payload);
      } else {
        await barangApi.create(payload);
      }

      this.$store.notify.show(isEdit ? 'Barang berhasil diperbarui.' : 'Barang berhasil ditambahkan.', 'success');
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.$store.notify.show(e.message || 'Gagal menyimpan data.', 'error');
    } finally {
      this.saving = false;
    }
  },

  // ── Aksi Stok ──

  openStockAction(action, item) {
    this.stockAction = action;
    this.stockItem = item;
    this.stockForm = { jumlah: '', stok_fisik: '', keterangan: '' };
    this.stockSaving = false;
  },

  closeStockAction() {
    this.stockAction = null;
    this.stockItem = null;
    this.stockForm = { jumlah: '', stok_fisik: '', keterangan: '' };
  },

  async submitStockAction() {
    if (!this.stockItem || !this.stockAction) return;

    this.stockSaving = true;
    this.$store.notify.clear();

    try {
      const id = this.stockItem.id;
      let payload;

      switch (this.stockAction) {
        case 'pengadaan':
          payload = { jumlah: Number(this.stockForm.jumlah), keterangan: this.stockForm.keterangan || null };
          await barangApi.pengadaan(id, payload);
          break;
        case 'hilang':
          payload = { jumlah: Number(this.stockForm.jumlah), keterangan: this.stockForm.keterangan || null };
          await barangApi.hilang(id, payload);
          break;
        case 'ketemu':
          payload = { jumlah: Number(this.stockForm.jumlah), keterangan: this.stockForm.keterangan || null };
          await barangApi.ketemu(id, payload);
          break;
        case 'opname':
          payload = { stok_fisik: Number(this.stockForm.stok_fisik), keterangan: this.stockForm.keterangan || null };
          await barangApi.opname(id, payload);
          break;
        case 'hapus-stok':
          payload = { jumlah: Number(this.stockForm.jumlah), keterangan: this.stockForm.keterangan || null };
          await barangApi.hapusStok(id, payload);
          break;
      }

      const actionLabels = {
        pengadaan: 'Pengadaan',
        hilang: 'Hilang',
        ketemu: 'Ketemu',
        opname: 'Opname',
        'hapus-stok': 'Hapus Stok',
      };

      this.$store.notify.show(`${actionLabels[this.stockAction]} berhasil dicatat.`, 'success');
      this.closeStockAction();
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal memproses aksi stok.', 'error');
    } finally {
      this.stockSaving = false;
    }
  },

  // ── Helpers ──

  stokTersedia(item) {
    return (item.jumlah_total || 0) - (item.jumlah_dipinjam || 0);
  },

  stokBadge(item) {
    const tersedia = this.stokTersedia(item);
    if (tersedia <= 0) return 'bg-red-100 text-red-700';
    if (tersedia <= (item.jumlah_dipinjam || 0)) return 'bg-yellow-100 text-yellow-700';
    return 'bg-green-100 text-green-700';
  },
});