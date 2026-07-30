import { isRequired } from '../utils/validation';
import { barangApi } from '../services/barangApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/barangMapper';
import { normalizePaginatedResponse } from '../utils/pagination';
import { useKategoriLookup } from '../composables/useKategoriLookup';
import { useLokasiLookup } from '../composables/useLokasiLookup';

export default () => ({
  loading: false,
  saving: false,
  error: null,
  success: null,
  search: '',

  items: [],
  meta: { current_page: 1, last_page: 1, total: 0 },

  // Form CRUD
  showModal: false,
  editingId: null,
  form: emptyForm(),

  // Confirm hapus
  confirmShow: false,
  deletingItem: null,

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

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await barangApi.paginate({ page, search: this.search });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal memuat data barang.';
    } finally {
      this.loading = false;
    }
  },

  openCreate() {
    this.editingId = null;
    this.form = emptyForm();
    this.showModal = true;
  },

  openEdit(item) {
    this.editingId = item.id;
    this.form = mapItemToForm(item);
    this.showModal = true;
  },

  async save() {
    if (!isRequired(this.form.nama_barang)) {
      this.error = 'Nama barang wajib diisi.';
      return;
    }

    this.saving = true;
    this.error = null;

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await barangApi.update(this.editingId, payload);
      } else {
        await barangApi.create(payload);
      }

      this.success = isEdit ? 'Barang berhasil diperbarui.' : 'Barang berhasil ditambahkan.';
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menyimpan data.';
    } finally {
      this.saving = false;
    }
  },

  openDelete(item) {
    this.deletingItem = item;
    this.confirmShow = true;
  },

  async remove() {
    if (!this.deletingItem) return;

    this.loading = true;
    this.error = null;

    try {
      await barangApi.remove(this.deletingItem.id);
      this.success = 'Barang berhasil dihapus.';
      this.confirmShow = false;
      this.deletingItem = null;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal menghapus data.';
    } finally {
      this.loading = false;
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
    this.error = null;

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

      this.success = `${actionLabels[this.stockAction]} berhasil dicatat.`;
      this.closeStockAction();
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal memproses aksi stok.';
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