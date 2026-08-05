/**
 * ─────────────────────────────────────────────────────────────
 * ACCESS CONTROL CONFIG — Single Source of Truth
 * ─────────────────────────────────────────────────────────────
 * Semua aturan akses (role, level, route guard, sidebar filter)
 * didefinisikan di sini. Jika ada perubahan role/akses, cukup
 * ubah file ini saja.
 *
 * Cara pakai:
 *   import { access } from '../config/access';
 *   access.isStaff(user.roles);
 * ─────────────────────────────────────────────────────────────
 */

// =============================================================
// 1. ROLE DEFINITIONS
// =============================================================
// Daftar semua role yang ada di sistem.
// Key = nama role (harus sama dengan database), Value = label
export const ROLES = {
    admin: "Admin",
    petugas: "Petugas",
    kepala_desa: "Kepala Desa",
};

// =============================================================
// 2. ACCESS LEVELS
// =============================================================
// Setiap level mendefinisikan role mana yang termasuk di dalamnya.
// Urutan dari paling rendah aksesnya ke paling tinggi.
export const ACCESS_LEVELS = {
    /** Publik — tanpa login */
    public: {
        label: "Publik",
        roles: [], // tidak pakai role, dicek via isLoggedIn
    },
    /** Login required — semua role */
    auth: {
        label: "Login Required",
        roles: ["admin", "petugas", "kepala_desa"],
    },
    /** Staff — pengelola data desa */
    staff: {
        label: "Staff",
        roles: ["admin", "petugas"],
    },
    /** Admin — manajemen sistem */
    admin: {
        label: "Admin",
        roles: ["admin"],
    },
};

// =============================================================
// 3. ROUTE ACCESS MAP
// =============================================================
// Setiap route prefix → level akses yang dibutuhkan.
// Digunakan oleh route guard di layout.
export const ROUTE_ACCESS = [
    // Public — tanpa login
    { prefix: "/login", level: "public" },
    { prefix: "/about", level: "public" },
    { prefix: "/peta-desa", level: "public" },
    { prefix: "/galeri", level: "public" },
    { prefix: "/bacaan", level: "public" },

    // Dashboard — public (data filtered by backend based on auth)
    { prefix: "/", level: "public" }, // dashboard

    // Public — semua orang (termasuk tanpa login)
    { prefix: "/surat", level: "public" },

    // Staff — admin & petugas
    { prefix: "/master-data", level: "staff" },
    { prefix: "/inventaris", level: "staff" },
    { prefix: "/manajemen-konten", level: "staff" },

    // Admin only
    { prefix: "/admin-sistem", level: "admin" },
];

// =============================================================
// 4. SIDEBAR MENU DEFINITIONS
// =============================================================
// level: 'public' | 'auth' | 'staff' | 'admin'

export const SIDEBAR_MENU = [
    // Top-level menu items
    { label: "Dashboard", route: "dashboard", icon: "home", level: "public" },
    {
        label: "Pembuatan Surat",
        route: "surat.index",
        icon: "document",
        level: "public",
    },
    { label: "Peta Desa", route: "peta-desa", icon: "map", level: "public" },
    { label: "Galeri Foto", route: "galeri", icon: "camera", level: "public" },
    {
        label: "Bacaan Edukatif",
        route: "bacaan.index",
        icon: "book",
        level: "public",
    },

    // Grup — Master Data Desa (staff)
    {
        group: "Master Data Desa",
        icon: "database",
        level: "staff",
        children: [
            { label: "Profil Desa", route: "master-data.profil-desa.index" },
            { label: "Dusun", route: "master-data.dusun.index" },
            { label: "RW", route: "master-data.rw.index" },
            { label: "RT", route: "master-data.rt.index" },
            { label: "KK / Kartu Keluarga", route: "master-data.kk.index" },
            { label: "Pendidikan", route: "master-data.pendidikan.index" },
            {
                label: "Jabatan Perangkat",
                route: "master-data.jabatan-perangkat.index",
            },
            {
                label: "Perangkat Desa",
                route: "master-data.perangkat-desa.index",
            },
            { label: "Penduduk", route: "master-data.penduduk.index" },
        ],
    },

    // Grup — Master Data Surat (staff)
    {
        group: "Master Data Surat",
        icon: "document",
        level: "staff",
        children: [
            {
                label: "Kategori Surat",
                route: "master-data.kategori-surat.index",
            },
            { label: "Jenis Surat", route: "master-data.jenis-surat.index" },
            {
                label: "Field Surat",
                route: "master-data.master-field-surat.index",
            },
            { label: "Riwayat Surat", route: "surat.riwayat" },
        ],
    },

    // Grup — Inventaris (staff)
    {
        group: "Inventaris Desa",
        icon: "box",
        level: "staff",
        children: [
            {
                label: "Kategori Barang",
                route: "inventaris.kategori-barang.index",
            },
            { label: "Lokasi", route: "inventaris.lokasi.index" },
            { label: "Daftar Barang", route: "inventaris.barang.index" },
            { label: "Peminjaman", route: "inventaris.peminjaman.index" },
            { label: "Mutasi / Buku Besar", route: "inventaris.mutasi.index" },
        ],
    },

    // Grup — Manajemen Konten (staff)
    {
        group: "Manajemen Konten",
        icon: "edit",
        level: "staff",
        children: [
            { label: "Artikel", route: "manajemen-konten.artikel.index" },
            { label: "Galeri", route: "manajemen-konten.galeri.index" },
        ],
    },

    // Grup — Admin Sistem (admin only)
    {
        group: "Admin Sistem",
        icon: "settings",
        level: "admin",
        children: [{ label: "User", route: "admin-sistem.user.index" }],
    },
];

// =============================================================
// 5. HELPER FUNCTIONS
// =============================================================

/**
 * Cek apakah user dengan roles tertentu punya akses ke level tertentu.
 * @param {string[]} userRoles — array role dari API (misal ['admin'])
 * @param {string} level — 'public' | 'auth' | 'staff' | 'admin'
 * @returns {boolean}
 */
export function canAccess(userRoles, level) {
    if (level === "public") return true;
    if (!userRoles || userRoles.length === 0) return false;

    const allowedRoles = ACCESS_LEVELS[level]?.roles ?? [];
    return userRoles.some((r) => allowedRoles.includes(r));
}

/**
 * Cek apakah user termasuk staff (admin/petugas).
 */
export function isStaff(userRoles) {
    return canAccess(userRoles, "staff");
}

/**
 * Cek apakah user adalah admin.
 */
export function isAdmin(userRoles) {
    return canAccess(userRoles, "admin");
}

/**
 * Cek apakah user adalah kepala desa.
 */
export function isKades(userRoles) {
    return userRoles?.includes("kepala_desa") ?? false;
}

/**
 * Cari level akses untuk suatu path URL.
 * @param {string} path — window.location.pathname
 * @returns {string} 'public' | 'auth' | 'staff' | 'admin'
 */
export function getRouteLevel(path) {
    // Cari yang prefix-nya paling panjang cocok (lebih spesifik)
    const sorted = [...ROUTE_ACCESS].sort(
        (a, b) => b.prefix.length - a.prefix.length,
    );
    for (const entry of sorted) {
        if (entry.prefix === "/") {
            // Root path — exact match only
            if (path === "/" || path === "") return entry.level;
        } else if (
            path === entry.prefix ||
            path.startsWith(entry.prefix + "/")
        ) {
            return entry.level;
        }
    }
    return "public"; // default aman
}
