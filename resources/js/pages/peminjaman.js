import { isRequired } from '../utils/validation';
import { peminjamanApi } from '../services/peminjamanApi';
import { UnauthorizedError } from '../services/httpClient';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/peminjamanMapper';
import { normalizePaginatedResponse } from '../utils/pagination';
import { useCrud } from '../composables/useCrud';
import { useBarangLookup } from '../composables/useBarangLookup';

export default () => ({
  ...useCrud({ api: peminjamanApi, mapper: { emptyForm, mapItemToForm, buildPayload }, entityName: 'Peminjaman' }),

  filterStatus: '',

  // Confirm batalkan
  confirmBatalShow: false,
  batalItem: null,

  // Lookup
  barangLookup: useBarangLookup(),

  async init() {
    await this.barangLookup.init();
    await this.load();
  },

  async load(page = 1) {
    this.loading = true;
    this.$store.notify.clear();

    try {
      const payload = await peminjamanApi.list({
        page,
        search: this.search,
        status: this.filterStatus || undefined,
      });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal memuat data peminjaman.', 'error');
    } finally {
      this.loading = false;
    }
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
      this.$store.notify.show('Nama peminjam wajib diisi.', 'error');
      return;
    }

    if (this.form.details.filter(d => d.barang_id && d.jumlah).length === 0) {
      this.$store.notify.show('Minimal satu barang harus diisi.', 'error');
      return;
    }

    this.saving = true;
    this.$store.notify.clear();

    try {
      const isEdit = !!this.editingId;
      const payload = buildPayload(this.form);

      if (isEdit) {
        await peminjamanApi.update(this.editingId, payload);
      } else {
        await peminjamanApi.create(payload);
      }

      this.$store.notify.show(isEdit ? 'Peminjaman berhasil diperbarui.' : 'Peminjaman berhasil dicatat.', 'success');
      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal menyimpan data.', 'error');
    } finally {
      this.saving = false;
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
    this.$store.notify.clear();

    try {
      await peminjamanApi.batalkan(this.batalItem.id);
      this.$store.notify.show('Peminjaman berhasil dibatalkan.', 'success');
      this.confirmBatalShow = false;
      this.batalItem = null;
      await this.load(this.meta.current_page);
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal membatalkan peminjaman.', 'error');
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