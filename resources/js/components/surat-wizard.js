import { isRequired, isNik } from "../utils/validation";

export default () => ({
    // ---- config ----
    baseUrl: window.API_BASE_URL || "/api",

    // ---- ui state ----
    step: 1,
    loading: false,
    error: null,
    success: null,

    // ---- step 1: pilih jenis surat ----
    jenisSuratList: [],
    selectedJenisSurat: null, // full detail incl. srt_jenis_surat_penduduks

    // ---- step 2: isi nik ----
    nikByRole: {}, // { kode: nik }
    keperluan: "",
    pengajuanId: null,

    // ---- step 3: isi data manual ----
    fields: [], // [{placeholder, mode, type, label, value}]
    dataSurat: {}, // { placeholder: value }

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
            const res = await fetch(`${this.baseUrl}/srt-jenis-surat`, {
                headers: { Accept: "application/json" },
            });
            if (!res.ok) {
                throw new Error("Gagal memuat jenis surat.");
            }

            const json = await res.json();
            this.jenisSuratList = (json.data && json.data.data) || [];
        } catch (e) {
            this.error = e.message || "Gagal memuat daftar jenis surat.";
        } finally {
            this.loading = false;
        }
    },

    // ---------------------------------------------------------------
    // STEP 1 (lanjutan)
    // ---------------------------------------------------------------
    async pilihJenisSurat(item) {
        this.loading = true;
        this.error = null;
        try {
            const res = await fetch(`${this.baseUrl}/srt-jenis-surat/${item.id}`, {
                headers: { Accept: "application/json" },
            });
            if (!res.ok) {
                this.error = "Gagal memuat detail jenis surat.";
                return;
            }

            const json = await res.json();

            if (!json.data)
                throw new Error("Detail jenis surat tidak ditemukan.");

            this.selectedJenisSurat = json.data;
            this.nikByRole = {};
            (json.data.srt_jenis_surat_penduduks || [])
                .sort((a, b) => a.urutan - b.urutan)
                .forEach((role) => {
                    this.nikByRole[role.kode] = "";
                });

            this.step = 2;
        } catch (e) {
            this.error = e.message || "Gagal memuat detail jenis surat.";
        } finally {
            this.loading = false;
        }
    },

    // ---------------------------------------------------------------
    // STEP 2
    // ---------------------------------------------------------------
    get rolesUrut() {
        if (!this.selectedJenisSurat) return [];
        return [
            ...(this.selectedJenisSurat.srt_jenis_surat_penduduks || []),
        ].sort((a, b) => a.urutan - b.urutan);
    },

    get canSubmitNik() {
        return this.rolesUrut
            .filter((r) => r.wajib)
            .every((r) => isRequired(this.nikByRole[r.kode]));
    },

    async submitNik() {
        if (!this.canSubmitNik) {
            this.error = "Lengkapi NIK untuk semua peran yang wajib diisi.";
            return;
        }

        // Validate NIK format for filled fields
        const roles = this.rolesUrut;
        for (const role of roles) {
            const nikVal = (this.nikByRole[role.kode] || "").trim();
            if (isRequired(nikVal) && !isNik(nikVal)) {
                this.error = `Format NIK untuk peran "${role.nama}" tidak valid (harus 16 digit angka).`;
                return;
            }
        }

        this.loading = true;
        this.error = null;
        try {
            const niks = this.rolesUrut.map((r) =>
                (this.nikByRole[r.kode] || "").trim(),
            );

            const body = {
                jenis_surat_id: this.selectedJenisSurat.id,
                niks,
                keperluan: this.keperluan || null,
            };

            const res = await fetch(`${this.baseUrl}/pengajuan-surat`, {
                method: "POST",
                headers: { Accept: "application/json", "Content-Type": "application/json" },
                body: JSON.stringify(body),
            });
            if (!res.ok) {
                const errJson = await res.json().catch(() => ({}));
                throw new Error(errJson.message || "Gagal mengajukan surat.");
            }

            const json = await res.json();
            this.pengajuanId = json.data.id;
            this.fields = (json.fields || []).map((f) => ({ ...f }));
            this.dataSurat = {};
            this.fields.forEach((f) => {
                this.dataSurat[f.placeholder] = f.value ?? "";
            });

            this.step = 3;
        } catch (e) {
            this.error = e.message || "Gagal mengirim data NIK.";
        } finally {
            this.loading = false;
        }
    },

    // ---------------------------------------------------------------
    // STEP 3
    // ---------------------------------------------------------------
    get manualFields() {
        return this.fields.filter((f) => f.mode === "manual");
    },

    get autoFields() {
        return this.fields.filter((f) => f.mode !== "manual");
    },

    get canGenerate() {
        return this.manualFields.every((f) =>
            isRequired(this.dataSurat[f.placeholder]),
        );
    },

    async generateSurat() {
        if (!this.canGenerate) {
            this.error = "Lengkapi seluruh data yang wajib diisi.";
            return;
        }
        this.loading = true;
        this.error = null;
        try {
            const res = await fetch(
                `${this.baseUrl}/pengajuan-surat/${this.pengajuanId}`,
                {
                    method: "POST",
                    headers: { Accept: "application/json", "Content-Type": "application/json" },
                    body: JSON.stringify({ data_surat: this.dataSurat }),
                },
            );
            if (!res.ok) {
                const errJson = await res.json().catch(() => ({}));
                throw new Error(errJson.message || "Gagal membuat surat.");
            }

            const json = await res.json();
            this.result = json.data;
            this.success = json.message || "Surat berhasil dibuat.";
            this.step = 4;
        } catch (e) {
            this.error = e.message || "Gagal membuat surat.";
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
        this.keperluan = "";
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
});
