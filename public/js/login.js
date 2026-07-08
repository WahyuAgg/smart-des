document.addEventListener('alpine:init', () => {
  Alpine.data('loginForm', () => ({
    baseUrl: window.API_BASE_URL || '/api',

    // ---- form state ----
    email: '',
    password: '',
    showPassword: false,

    // ---- ui state ----
    loading: false,
    error: null,

    init() {
      // Jika sudah login, langsung redirect ke dashboard
      if (Auth.isLoggedIn()) {
        window.location.href = '/';
        return;
      }
    },

    async submit() {
      if (!this.email || !this.password) {
        this.error = 'Email dan password wajib diisi.';
        return;
      }

      this.loading = true;
      this.error = null;

      try {
        const res = await fetch(`${this.baseUrl}/login`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        });

        const json = await res.json();

        if (!res.ok) {
          throw new Error(json.message || 'Email atau password salah.');
        }

        // Simpan token & user ke localStorage
        Auth.setSession(json.token, json.user);

        // Redirect ke dashboard
        window.location.href = '/';
      } catch (e) {
        this.error = e.message || 'Gagal login. Silakan coba lagi.';
      } finally {
        this.loading = false;
      }
    },
  }));
});
