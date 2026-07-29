import { apiFetch, baseUrl } from './httpClient';

export const appInfoApi = {
  async get() {
    return apiFetch(`${baseUrl}/app-info`);
  },
};