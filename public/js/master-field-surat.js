document.addEventListener('alpine:init', () => {
  Alpine.data('masterFieldSurat', () => ({
    // ---- config ----
    baseUrl: window.API_BASE_URL || '/api',
    endpoint: 'srt-master-field-surat',

    // ---- ui state ----
    loading: false,
    saving: false,
    error: null,
    success: null,
    search: '',

    // ---- list state ----
    items: [],
    meta: { current_page: 1, last_page: 1, total: 0 },

    // ---- modal / form state ----
    showModal: false,
    editingId: null,
    form: emptyForm(),

    // ---- delete state ----
    confirmShow: false,
    deletingItem: null,

    async init() {
      if (!Auth.requireAuth()) return;
      await this.load();
    },

    // ---------------------------------------------------------------
    // LIST
    // ---------------------------------------------------------------
    async load(page = 1) {
      this.loading = true;
      this.error = null;
      try {
        const params = new URLSearchParams({ page, search: this.search || '' });
        const res = await fetch(`${this.baseUrl}/${this.endpoint}?${params.toString()}`, {
          headers: Auth.headers(),
        });
        if (Auth.handleUnauthorized(res)) return;

        const json = await res.json();
        if (!json.success && json.success !== undefined) {
          throw new Error(json.message || 'Gagal memuat data.');
        }

        const payload = json.data ?? json;
        this.items = payload.data ?? payload;
        this.meta = {
          current_page: payload.current_page ?? 1,
          last_page: payload.last_page ?? 1,
          total: payload.total ?? this.items.length,
        };
      } catch (e) {
        this.error = e.message || 'Gagal memuat data field surat.';
      } finally {
        this.loading = false;
      }
    },

    // ---------------------------------------------------------------
    // CREATE / EDIT
    // ---------------------------------------------------------------
    openCreate() {
      this.editingId = null;
      this.form = emptyForm();
      this.showModal = true;
    },

    openEdit(item) {
      this.editingId = item.id;
      this.form = {
        nama: item.nama ?? '',
        label: item.label ?? '',
        tipe: item.tipe ?? 'text',
        placeholder: item.placeholder ?? '',
        keterangan: item.keterangan ?? '',
        input_mode: item.input_mode ?? 'manual',
        source: item.source ?? '',
        source_field: item.source_field ?? '',
      };
      this.showModal = true;
    },

    async save() {
      if (!this.form.nama || !this.form.label || !this.form.input_mode || !this.form.tipe) {
        this.error = 'Nama, label, tipe, dan input mode wajib diisi.';
        return;
      }

      this.saving = true;
      this.error = null;
      try {
        const isEdit = !!this.editingId;
        const url = isEdit ? `${this.baseUrl}/${this.endpoint}/${this.editingId}` : `${this.baseUrl}/${this.endpoint}`;

        const res = await fetch(url, {
          method: isEdit ? 'PUT' : 'POST',
          headers: Auth.headers({ 'Content-Type': 'application/json' }),
          body: JSON.stringify({
            ...this.form,
            source: this.form.source || null,
            source_field: this.form.source_field || null,
          }),
        });
        if (Auth.handleUnauthorized(res)) return;

        const json = await res.json();
        if (!res.ok || (json.success !== undefined && !json.success)) {
          throw new Error(json.message || 'Gagal menyimpan data.');
        }

        this.showModal = false;
        this.success = isEdit ? 'Field surat berhasil diperbarui.' : 'Field surat berhasil ditambahkan.';
        await this.load(this.meta.current_page);
      } catch (e) {
        this.error = e.message || 'Gagal menyimpan data.';
      } finally {
        this.saving = false;
      }
    },

    // ---------------------------------------------------------------
    // DELETE
    // ---------------------------------------------------------------
    openDelete(item) {
      this.deletingItem = item;
      this.confirmShow = true;
    },

    async remove() {
      if (!this.deletingItem) return;
      this.loading = true;
      this.error = null;
      try {
        const res = await fetch(`${this.baseUrl}/${this.endpoint}/${this.deletingItem.id}`, {
          method: 'DELETE',
          headers: Auth.headers(),
        });
        if (Auth.handleUnauthorized(res)) return;

        const json = await res.json().catch(() => ({}));
        if (!res.ok || (json.success !== undefined && !json.success)) {
          throw new Error(json.message || 'Gagal menghapus data.');
        }

        this.success = 'Field surat berhasil dihapus.';
        this.confirmShow = false;
        this.deletingItem = null;
        await this.load(this.meta.current_page);
      } catch (e) {
        this.error = e.message || 'Gagal menghapus data.';
      } finally {
        this.loading = false;
      }
    },

    // ---------------------------------------------------------------
    // HELPERS
    // ---------------------------------------------------------------
    inputModeLabel(mode) {
      return { auto: 'Otomatis', manual: 'Manual', auto_editable: 'Otomatis (edit)' }[mode] || mode;
    },

    inputModeBadge(mode) {
      return {
        auto: 'bg-slate-100 text-slate-600',
        manual: 'bg-amber-100 text-amber-700',
        auto_editable: 'bg-accent-light text-accent-hover',
      }[mode] || 'bg-slate-100 text-slate-600';
    },
  }));
});

function emptyForm() {
  return {
    nama: '',
    label: '',
    tipe: 'text',
    placeholder: '',
    keterangan: '',
    input_mode: 'manual',
    source: '',
    source_field: '',
  };
}
