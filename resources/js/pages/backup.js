import { backupApi } from '../services/backupApi';
import { UnauthorizedError } from '../services/httpClient';

export default () => ({
  loading: false,
  error: null,
  success: null,

  async downloadStorageFiles() {
    await this.download(() => backupApi.downloadStorageFiles(), 'Backup storage berhasil diunduh.');
  },

  async downloadDatabaseSqlite() {
    await this.download(() => backupApi.downloadDatabaseSqlite(), 'Backup database berhasil diunduh.');
  },

  async download(action, successMessage) {
    this.loading = true;
    this.error = null;
    this.success = null;

    try {
      await action();
      this.success = successMessage;
    } catch (error) {
      if (error instanceof UnauthorizedError) return;
      this.error = error.message || 'Gagal mengunduh backup.';
    } finally {
      this.loading = false;
    }
  },
});