import { Auth } from '../services/auth';
import { userApi } from '../services/userApi';
import { UnauthorizedError } from '../services/httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';
import { emptyForm, mapItemToForm, buildPayload } from '../mappers/userMapper';

export default () => ({
  loading: false,
  saving: false,
  error: null,
  success: null,
  search: '',
  roleFilter: '',

  items: [],
  meta: { current_page: 1, last_page: 1, total: 0 },

  // Role options for dropdowns
  roles: [],

  // Current user ID (for business rules)
  currentUserId: null,

  showModal: false,
  editingId: null,
  form: emptyForm(),

  confirmShow: false,
  deletingItem: null,

  async init() {
    if (!Auth.requireAuth()) return;
    this.currentUserId = Auth.getUser()?.id || null;
    await Promise.all([this.load(), this.loadRoles()]);
  },

  async loadRoles() {
    try {
      this.roles = await userApi.fetchRoles();
    } catch {
      this.roles = [];
    }
  },

  async load(page = 1) {
    this.loading = true;
    this.error = null;

    try {
      const payload = await userApi.paginate({
        page,
        search: this.search,
        role: this.roleFilter,
        perPage: 10,
      });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal memuat data user.';
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
    this.saving = true;
    this.error = null;
    this.success = null;

    try {
      const payload = buildPayload(this.form);

      if (this.editingId) {
        await userApi.update(this.editingId, payload);
        this.success = 'User berhasil diperbarui.';
      } else {
        await userApi.create(payload);
        this.success = 'User berhasil ditambahkan.';
      }

      this.showModal = false;
      await this.load(this.meta.current_page);
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal menyimpan user.';
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
    this.saving = true;

    try {
      await userApi.remove(this.deletingItem.id);
      this.success = 'User berhasil dihapus.';
      this.confirmShow = false;
      this.deletingItem = null;
      await this.load();
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal menghapus user.';
    } finally {
      this.saving = false;
    }
  },

  async toggleActive(item) {
    this.saving = true;
    this.error = null;
    this.success = null;

    try {
      await userApi.toggleActive(item.id);
      this.success = item.is_active
        ? 'User berhasil dinonaktifkan.'
        : 'User berhasil diaktifkan.';
      await this.load(this.meta.current_page);
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.error = e.message || 'Gagal mengubah status user.';
    } finally {
      this.saving = false;
    }
  },

  isSelf(itemId) {
    return Number(itemId) === Number(this.currentUserId);
  },

  get roleOptions() {
    return this.roles.map(r => ({ value: r.name, label: r.name.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase()) }));
  },
});