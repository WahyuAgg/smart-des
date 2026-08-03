import { userApi } from '../services/userApi';
import { UnauthorizedError } from '../services/httpClient';
import { normalizePaginatedResponse } from '../utils/pagination';
import { useCrud } from '../composables/useCrud';
import * as mapper from '../mappers/userMapper';

export default () => ({
  ...useCrud({ api: userApi, mapper, entityName: 'User' }),

  roleFilter: '',
  roles: [],
  currentUserId: null,

  async init() {
    await Promise.all([this.load(), this.loadRoles()]);
  },

  async loadRoles() {
    try { this.roles = await userApi.fetchRoles(); }
    catch { this.roles = []; }
  },

  async load(page = 1) {
    this.loading = true;
    this.$store.notify.clear();

    try {
      const payload = await userApi.list({ page, search: this.search, role: this.roleFilter, perPage: 10 });
      const { items, meta } = normalizePaginatedResponse(payload);
      this.items = items;
      this.meta = meta;
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.$store.notify.show(e.message || 'Gagal memuat data user.', 'error');
    } finally {
      this.loading = false;
    }
  },

  async toggleActive(item) {
    this.saving = true;
    this.$store.notify.clear();

    try {
      await userApi.toggleActive(item.id);
      this.$store.notify.show(item.is_active ? 'User berhasil dinonaktifkan.' : 'User berhasil diaktifkan.', 'success');
      await this.load(this.meta.current_page);
    } catch (e) {
      if (e instanceof UnauthorizedError) return;
      this.$store.notify.show(e.message || 'Gagal mengubah status user.', 'error');
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