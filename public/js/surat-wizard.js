document.addEventListener('alpine:init', () => {
  Alpine.data('suratWizard', () => ({
    // ---- config ----
    baseUrl: window.API_BASE_URL || '/api',

    // ---- ui state ----
    step: 1,
    loading: false,
    error: null,
    success: null,

    // ---- step 1: pilih jenis surat ----
    jenisSuratList: [],
    selectedJenisSurat: null, // full detail incl. srt_jenis_surat_penduduks

    // ---- step 2: isi nik ----
    nikByRole: {},   // { kode: nik }
    keperluan: '',
    pengajuanId: null,

    // ---- step 3: isi data manual ----
    fields: [],      // [{placeholder, mode, type, label, value}]
    dataSurat: {},   // { placeholder: value }

    // ---- step 4: hasil ----
    result: null,

    async init() {
      await this.loadJenisSurat();
    },

    // ---------------------------------------------------------------
    // STEP 1
    // ---------------------------------------------------------------
    async loadJenisSurat() {
      this.loading = true;
      this.error = null;
      try {
        const res = await fetch(`${this.baseUrl}/jenis-surat`);
        const json = await res.json();
        if (!json.success) throw new Error(json.message || 'Gagal memuat jenis surat.');
        this.jenisSuratList = (json.data && json.data.data) || [];
      } catch (e) {
        this.error = e.message || 'Gagal memuat daftar jenis surat.';
      } finally {
        this.loading = false;
      }
    },

    async pilihJenisSurat(item) {
      this.loading = true;
      this.error = null;
      try {
        const res = await fetch(`${this.baseUrl}/jenis-surat/${item.id}`);
        const json = await res.json();
        if (!json.jenis_surat) throw new Error('Detail jenis surat tidak ditemukan.');

        this.selectedJenisSurat = json.jenis_surat;
        this.nikByRole = {};
        (json.jenis_surat.srt_jenis_surat_penduduks || [])
          .sort((a, b) => a.urutan - b.urutan)
          .forEach(role => { this.nikByRole[role.kode] = ''; });

        this.step = 2;
      } catch (e) {
        this.error = e.message || 'Gagal memuat detail jenis surat.';
      } finally {
        this.loading = false;
      }
    },

    // ---------------------------------------------------------------
    // STEP 2
    // ---------------------------------------------------------------
    get rolesUrut() {
      if (!this.selectedJenisSurat) return [];
      return [...(this.selectedJenisSurat.srt_jenis_surat_penduduks || [])]
        .sort((a, b) => a.urutan - b.urutan);
    },

    get canSubmitNik() {
      return this.rolesUrut
        .filter(r => r.wajib)
        .every(r => (this.nikByRole[r.kode] || '').trim().length > 0);
    },

    async submitNik() {
      if (!this.canSubmitNik) {
        this.error = 'Lengkapi NIK untuk semua peran yang wajib diisi.';
        return;
      }
      this.loading = true;
      this.error = null;
      try {
        const niks = this.rolesUrut.map(r => (this.nikByRole[r.kode] || '').trim());

        const res = await fetch(`${this.baseUrl}/pengajuan-surat`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
          body: JSON.stringify({
            jenis_surat_id: this.selectedJenisSurat.id,
            niks,
            keperluan: this.keperluan || null,
          }),
        });
        const json = await res.json();
        if (!json.success) throw new Error(json.message || 'Gagal mengajukan surat.');

        this.pengajuanId = json.data.id;
        this.fields = (json.fields || []).map(f => ({ ...f }));
        this.dataSurat = {};
        this.fields.forEach(f => { this.dataSurat[f.placeholder] = f.value ?? ''; });

        this.step = 3;
      } catch (e) {
        this.error = e.message || 'Gagal mengirim data NIK.';
      } finally {
        this.loading = false;
      }
    },

    // ---------------------------------------------------------------
    // STEP 3
    // ---------------------------------------------------------------
    get manualFields() {
      return this.fields.filter(f => f.mode === 'manual');
    },

    get autoFields() {
      return this.fields.filter(f => f.mode !== 'manual');
    },

    get canGenerate() {
      return this.manualFields.every(f => `${this.dataSurat[f.placeholder] ?? ''}`.trim().length > 0);
    },

    async generateSurat() {
      if (!this.canGenerate) {
        this.error = 'Lengkapi seluruh data yang wajib diisi.';
        return;
      }
      this.loading = true;
      this.error = null;
      try {
        const res = await fetch(`${this.baseUrl}/pengajuan-surat/${this.pengajuanId}`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
          body: JSON.stringify({ data_surat: this.dataSurat }),
        });
        const json = await res.json();
        if (!json.success) throw new Error(json.message || 'Gagal membuat surat.');

        this.result = json.data;
        this.success = json.message || 'Surat berhasil dibuat.';
        this.step = 4;
      } catch (e) {
        this.error = e.message || 'Gagal membuat surat.';
      } finally {
        this.loading = false;
      }
    },

    // ---------------------------------------------------------------
    // STEP 4 / reset
    // ---------------------------------------------------------------
    mulaiLagi() {
      this.step = 1;
      this.selectedJenisSurat = null;
      this.nikByRole = {};
      this.keperluan = '';
      this.pengajuanId = null;
      this.fields = [];
      this.dataSurat = {};
      this.result = null;
      this.error = null;
      this.success = null;
    },

    kembali() {
      if (this.step > 1) this.step -= 1;
      this.error = null;
    },
  }));
});
