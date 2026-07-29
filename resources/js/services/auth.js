/**
 * Auth Helper — Reusable token manager untuk Sanctum SPA auth.
 *
 * Menyimpan token & user di localStorage.
 */

const TOKEN_KEY = 'auth_token';
const USER_KEY  = 'auth_user';

export const Auth = {
  /**
   * Ambil token dari localStorage.
   */
  getToken() {
    return localStorage.getItem(TOKEN_KEY);
  },

  /**
   * Ambil user object dari localStorage.
   */
  getUser() {
    try {
      const raw = localStorage.getItem(USER_KEY);
      return raw ? JSON.parse(raw) : null;
    } catch {
      return null;
    }
  },

  /**
   * Simpan token + user setelah login berhasil.
   */
  setSession(token, user) {
    localStorage.setItem(TOKEN_KEY, token);
    localStorage.setItem(USER_KEY, JSON.stringify(user));
  },

  /**
   * Hapus session (logout).
   */
  clear() {
    localStorage.removeItem(TOKEN_KEY);
    localStorage.removeItem(USER_KEY);
  },

  /**
   * Cek apakah user sudah login.
   */
  isLoggedIn() {
    return !!this.getToken();
  },

  /**
   * Return headers object untuk fetch.
   * Jika belum login, tetap return Accept header saja.
   */
  headers(extra = {}) {
    const h = { Accept: 'application/json', ...extra };
    const token = this.getToken();
    if (token) {
      h['Authorization'] = `Bearer ${token}`;
    }
    return h;
  },

  /**
   * Redirect ke /login jika belum login.
   * Panggil di init() halaman yang butuh auth.
   */
  requireAuth() {
    if (!this.isLoggedIn()) {
      window.location.href = '/login';
      return false;
    }
    return true;
  },

  /**
   * Cek response fetch. Jika 401, clear session & redirect ke login.
   * Return true jika harus stop proses (karena redirect).
   */
  handleUnauthorized(response) {
    if (response.status === 401) {
      this.clear();
      window.location.href = '/login';
      return true;
    }
    return false;
  },

  /**
   * Logout: fetch API logout, clear session, redirect.
   */
  async logout(baseUrl) {
    const url = (baseUrl || window.API_BASE_URL || '/api') + '/logout';
    try {
      await fetch(url, {
        method: 'POST',
        headers: this.headers(),
      });
    } catch {
      // Abaikan error network saat logout
    }
    this.clear();
    window.location.href = '/login';
  },

  /**
   * Fetch user data from /api/me and update localStorage.
   * Call after login or when user data may have changed (role, name, etc).
   * Returns the user object, or null if unauthhenticated.
   */
  async fetchUser(baseUrl) {
    const url = (baseUrl || window.API_BASE_URL || '/api') + '/me';
    try {
      const res = await fetch(url, {
        method: 'GET',
        headers: this.headers(),
      });
      if (res.status === 401) {
        this.clear();
        return null;
      }
      const data = await res.json();
      // Update localStorage with fresh user data
      const token = this.getToken();
      if (token) {
        this.setSession(token, data);
      }
      return data;
    } catch {
      return this.getUser(); // fallback ke cache
    }
  },
};
