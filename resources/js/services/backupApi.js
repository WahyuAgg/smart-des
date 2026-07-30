import { Auth } from './auth';
import { baseUrl, UnauthorizedError } from './httpClient';

async function downloadBlob(endpoint, fallbackFilename) {
  const response = await fetch(`${baseUrl}${endpoint}`, {
    method: 'GET',
    headers: Auth.headers(),
  });

  if (Auth.handleUnauthorized(response)) {
    throw new UnauthorizedError();
  }

  if (!response.ok) {
    let message = 'Gagal mengunduh backup.';

    try {
      const payload = await response.json();
      message = payload.message || message;
    } catch {
      const text = await response.text().catch(() => '');
      if (text) message = text;
    }

    throw new Error(message);
  }

  const blob = await response.blob();
  const contentDisposition = response.headers.get('content-disposition') || '';
  const filenameMatch = contentDisposition.match(/filename\*=UTF-8''([^;]+)|filename="?([^";]+)"?/i);
  const filename = decodeURIComponent(filenameMatch?.[1] || filenameMatch?.[2] || fallbackFilename);

  const objectUrl = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.href = objectUrl;
  link.download = filename;
  link.style.display = 'none';
  document.body.appendChild(link);
  link.click();
  link.remove();
  URL.revokeObjectURL(objectUrl);

  return filename;
}

export const backupApi = {
  downloadStorageFiles() {
    return downloadBlob('/backup/download-storage-files', `backup-storage-${new Date().toISOString().replace(/[:.]/g, '-')}.zip`);
  },

  downloadDatabaseSqlite() {
    return downloadBlob('/backup/download-database-sqlite', `smartdes-${new Date().toISOString().replace(/[:.]/g, '-')}.sqlite`);
  },
};