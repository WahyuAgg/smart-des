import { Auth } from '../services/auth';
import { isRequired } from '../utils/validation';
import { peminjamanApi } from '../services/peminjamanApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/peminjamanMapper';
import { normalizePaginatedResponse } from '../utils/pagination';
import { useBarangLookup } from '../composables/useBarangLookup';

export default () => ({
  loading: false,
  saving: false,
  error: null,
  success: null,
  search: '',

  items: [],
  meta: { current_page: 1, last_page: 1, total: 0 },

  filterStatus: '',

  // Form CRUD
  showModal: false,
  editingId: null,
  form: emptyForm(),

  // Confirm hapus
  confirmShow: false,
  deletingItem: null,

  // Confirm batalkan
  confirmBatalShow: false,
  batalItem: null,

  // Lookup
  barangLookup: useBarangLookup(),

  async init() {
    if (!Auth.requireAuth()) return;
    await this.barangLookup.init();
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await peminjamanApi.paginate({
        page,
        search: this.search,
        status: this.filterStatus || undefined,
      });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal memuat data peminjaman.';
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

  addDetailRow() {
    this.form.details.push({ barang_id: '', jumlah: '' });
  },

  removeDetailRow(index) {
    if (this.form.details.length <= 1) return;
    this.form.details.splice(index, 1);
  },

  async save() {
    if (!isRequired(this.form.nama_peminjam)) {
      this.error = 'Nama peminjam wajib diisi.';
      return;
    }

    if (this.form.details.filter(d => d.barang_id && d.jumlah).length === 0) {
      this.error = 'Minimal satu barang harus diisi.';
      return;
    }

    this.saving = true;
    this.error = null;

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await peminjamanApi.update(this.editingId, payload);
      } else {
        await peminjamanApi.create(payload);
      }

      this.success = isEdit ? 'Peminjaman berhasil diperbarui.' : 'Peminjaman berhasil dicatat.';
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
      await peminjamanApi.remove(this.deletingItem.id);
      this.success = 'Peminjaman berhasil dihapus.';
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

  // ── Batalkan Peminjaman ──
  openBatal(item) {
    this.batalItem = item;
    this.confirmBatalShow = true;
  },

  async batalkan() {
    if (!this.batalItem) return;
    this.loading = true;
    this.error = null;

    try {
      await peminjamanApi.batalkan(this.batalItem.id);
      this.success = 'Peminjaman berhasil dibatalkan.';
      this.confirmBatalShow = false;
      this.batalItem = null;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal membatalkan peminjaman.';
    } finally {
      this.loading = false;
    }
  },

  // ── Helpers ──
  statusBadge(status) {
    const map = {
      dipinjam: 'bg-blue-100 text-blue-700',
      dikembalikan: 'bg-green-100 text-green-700',
      dibatalkan: 'bg-red-100 text-red-700',
      sebagian: 'bg-yellow-100 text-yellow-700',
    };
    return map[status] || 'bg-slate-100 text-slate-600';
  },

  statusLabel(status) {
    const map = {
      dipinjam: 'Dipinjam',
      dikembalikan: 'Dikembalikan',
      dibatalkan: 'Dibatalkan',
      sebagian: 'Sebagian',
    };
    return map[status] || status;
  },
});