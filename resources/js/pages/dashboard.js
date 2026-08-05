import { dashboardApi } from "../services/dashboardApi";
import { Auth } from "../services/auth";
import { UnauthorizedError } from "../services/httpClient";

export default () => ({
    error: null,
    /** Data dari API - backend sudah filter berdasarkan auth */
    profilDesa: null,
    dashboard: null,
    perangkatDesa: [],
    riwayatSurat: [],
    peminjamanInventaris: [],
    loading: true,

    async init() {
        await this.fetchAll();
    },

    async fetchAll() {
        this.loading = true;
        this.error = null;
        this.$store.notify.clear();

        try {
            // Single API call - backend returns all data based on auth status
            const data = await dashboardApi.get();

            // Destructure response
            this.profilDesa = data.profil_desa;
            this.dashboard = data;
            this.perangkatDesa = data.perangkat_desa ?? [];
            this.riwayatSurat = data.riwayat_surat ?? [];
            this.peminjamanInventaris = data.peminjaman_inventaris ?? [];
        } catch (e) {
            if (e instanceof UnauthorizedError) return;
            this.error = e.message || "Gagal memuat data dashboard";
        } finally {
            this.loading = false;
        }
    },

    /** Check if user is authenticated (for conditional rendering) */
    get isAuthenticated() {
        return Auth.isLoggedIn();
    },

    /** Helper: jumlah dari distribusi_umur */
    get totalDistribusiUmur() {
        if (!this.dashboard?.distribusi_umur) return 0;
        return Object.values(this.dashboard.distribusi_umur).reduce(
            (sum, d) => sum + d.jumlah,
            0,
        );
    },

    /** Helper: persentase */
    pct(value, total) {
        if (!total || total === 0) return 0;
        return ((value / total) * 100).toFixed(1);
    },

    /** Helper: nilai maksimum dari dataset chart */
    maxVal(list) {
        if (!list) return 1;
        const items = Array.isArray(list) ? list : Object.values(list);
        if (!items.length) return 1;
        const max = Math.max(...items.map((i) => Number(i.jumlah) || 0));
        return max > 0 ? max : 1;
    },

    /** Helper: persentase bar relatif terhadap nilai maksimum (dengan min-width agar terlihat) */
    barPct(value, max) {
        if (!max || max === 0 || !value) return 0;
        const p = (value / max) * 100;
        return Math.max(p, 3).toFixed(1);
    },

    // formatDate: menggunakan $formatDate magic global (via Alpine) di Blade view

    /** Warna untuk chart */
    chartColors: [
        "#0D9488",
        "#14B8A6",
        "#2DD4BF",
        "#5EEAD4",
        "#F59E0B",
        "#F97316",
        "#EF4444",
        "#8B5CF6",
        "#EC4899",
        "#06B6D4",
        "#84CC16",
        "#6366F1",
    ],

    /** Warna untuk distribusi umur */
    ageColors: [
        "#06B6D4",
        "#0D9488",
        "#14B8A6",
        "#2DD4BF",
        "#F59E0B",
        "#F97316",
        "#EF4444",
        "#EC4899",
        "#8B5CF6",
        "#6366F1",
        "#84CC16",
        "#10B981",
        "#3B82F6",
        "#F43F5E",
    ],

    /** Warna badge status surat */
    badgeColor(status) {
        const map = {
            diajukan: "bg-yellow-100 text-yellow-700",
            diproses: "bg-blue-100 text-blue-700",
            selesai: "bg-green-100 text-green-700",
            ditolak: "bg-red-100 text-red-700",
        };
        return map[status] || "bg-slate-100 text-slate-600";
    },

    /** Ikon status surat */
    statusIcon(status) {
        const map = {
            diajukan: "M12 6v6l4 2",
            diproses: "M12 8v4l3 3M4 4v5h5",
            selesai: "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z",
            ditolak: "M18 6L6 18M6 6l12 12",
        };
        return map[status] || "M12 6v6l4 2";
    },

    /** Ambil warna berdasarkan index */
    color(i) {
        return this.chartColors[i % this.chartColors.length];
    },
    ageColor(i) {
        return this.ageColors[i % this.ageColors.length];
    },
});
