import { backupApi } from '../services/backupApi';
import { UnauthorizedError } from '../services/httpClient';

export default () => ({
  loading: false,

  async downloadStorageFiles() {
    await this.download(() => backupApi.downloadStorageFiles(), 'Backup storage berhasil diunduh.');
  },

  async downloadDatabaseSqlite() {
    await this.download(() => backupApi.downloadDatabaseSqlite(), 'Backup database berhasil diunduh.');
  },

  async download(action, successMessage) {
    this.loading = true;
    this.$store.notify.clear();

    try {
      await action();
      this.$store.notify.show(successMessage, 'success');
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.$store.notify.show(error.message || 'Gagal mengunduh backup.', 'error');
    } finally {
      this.loading = false;
    }
  },
});