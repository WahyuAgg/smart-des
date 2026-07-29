# Project Resource Structure

> **Purpose of this file:** Guide maintainers to quickly locate the correct file type when adding or modifying features. Update this file whenever a new directory, page, or module is added.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel |
| Frontend | Alpine.js (interactivity) |
| Bundler | Vite |
| Styling | Blade templates + CSS |

---

## 📁 `resources/views/` — Blade Templates

### `layouts/`
Base layouts extended by all pages.

| File | Purpose |
|------|---------|
| `app.blade.php` | Main layout (logged-in) — sidebar, navbar, footer, `@yield('title', 'content', etc.)` |
| `auth.blade.php` | Auth layout (login) — no sidebar |

### `partials/`
Layout fragments included once in `app.blade.php`.

| File | Purpose |
|------|---------|
| `sidebar.blade.php` | Sidebar navigation menu |
| `navbar.blade.php` | Top navbar |
| `footer.blade.php` | Footer |
| `head.blade.php` | `<head>` — meta, title, CSS assets |

### `components/`
Reusable Blade components (`<x-nama-komponent ... />` or `@include`).

| File | Purpose |
|------|---------|
| `alert.blade.php` | Success/error notification |
| `master-data-toolbar.blade.php` | Generic toolbar (title, search, add button) |
| `modal.blade.php` | Generic modal dialog |
| `confirm-dialog.blade.php` | Delete confirmation dialog |
| `pagination.blade.php` | Pagination navigation |
| `step-indicator.blade.php` | Step indicator for surat wizard (4 steps) |
| `form/input.blade.php` | Generic text input |
| `form/select.blade.php` | Generic select dropdown |
| `form/textarea.blade.php` | Generic textarea |

### `auth/`
| File | Purpose |
|------|---------|
| `login.blade.php` | Login page |

### `dashboard/`
| File | Purpose |
|------|---------|
| `index.blade.php` | Dashboard homepage |
| `partials/` | Charts & stat cards (agama, pekerjaan, pendidikan, umur, profile-header, stat-cards) |

### `about/`
| File | Purpose |
|------|---------|
| `index.blade.php` | About page |

### `bacaan/`
| File | Purpose |
|------|---------|
| `index.blade.php` | Bacaan edukatif list |
| `show.blade.php` | Bacaan edukatif detail |

### `peta-desa/`
| File | Purpose |
|------|---------|
| `index.blade.php` | Village map page |

### `manajemen-konten/artikel/`
| File | Purpose |
|------|---------|
| `index.blade.php` | Artikel CRUD management |
| `partials/` | Table & form partials |

---

#### Master Data (`master-data/`)
CRUD pages. Each entity follows the same pattern: `index.blade.php` + `partials/table.blade.php` + `partials/form.blade.php` (or `form-*.blade.php`).

| Directory | Entity | API Endpoint |
|-----------|--------|-------------|
| `kk/` | Kartu Keluarga | `/api/kk` |
| `pendidikan/` | Pendidikan | `/api/pendidikan` |
| `master-field-surat/` | Field Surat | `/api/srt-master-field-surat` |
| `penduduk/` | Penduduk | `/api/penduduk` |
| `kategori-surat/` | Kategori Surat | `/api/srt-kategori-surat` |
| `dusun/` | Dusun | `/api/ref-dusun` |
| `rw/` | RW | `/api/ref-rw` |
| `rt/` | RT | `/api/ref-rt` |
| `jabatan-perangkat/` | Jabatan Perangkat Desa | `/api/ref-jabatan-perangkat` |
| `perangkat-desa/` | Perangkat Desa | `/api/ref-perangkat-desa` |
| `profil-desa/` | Profil Desa | `/api/ref-profil-desa` |

#### Inventaris (`inventaris/`)

| Directory | Entity | API Endpoint |
|-----------|--------|-------------|
| `kategori-barang/` | Kategori Barang | `/api/inv-kategori-barang` |
| `lokasi/` | Lokasi Barang | `/api/inv-lokasi` |
| `barang/` | Barang Inventaris | `/api/inv-barang` |
| `peminjaman/` | Peminjaman Barang | `/api/inv-peminjaman` |
| `mutasi/` | Mutasi / Buku Besar | `/api/inv-mutasi` |

#### Surat (`surat/`)
Multi-step wizard (not CRUD).

| File | Purpose |
|------|---------|
| `index.blade.php` | Main wizard page (4 steps) |
| `steps/pilih-jenis-surat.blade.php` | Step 1: choose letter type |
| `steps/isi-nik.blade.php` | Step 2: enter NIK |
| `steps/isi-data-manual.blade.php` | Step 3: fill additional data |
| `steps/preview-download.blade.php` | Step 4: preview & download |

---

## 📁 `resources/js/` — JavaScript / Alpine.js

### `app.js`
Entry point. Registers all Alpine components, plugins (`@alpinejs/collapse`), and global services (`Auth`, `barangApi`, `peminjamanApi`, `mutasiApi`), plus a global `$formatDate` magic.

### `pages/`
Alpine components — each exports a factory function registered via `Alpine.data()` in `app.js`.

| File | Alpine Name | Entity |
|------|-------------|--------|
| `kk.js` | `kkCrud` | Kartu Keluarga |
| `pendidikan.js` | `pendidikanCrud` | Pendidikan |
| `master-field-surat.js` | `masterFieldSurat` | Field Surat |
| `penduduk.js` | `pendudukCrud` | Penduduk |
| `kategori-surat.js` | `kategoriSuratCrud` | Kategori Surat |
| `dusun.js` | `dusunCrud` | Dusun |
| `rw.js` | `rwCrud` | RW |
| `rt.js` | `rtCrud` | RT |
| `jabatan-perangkat.js` | `jabatanPerangkatCrud` | Jabatan Perangkat |
| `perangkat-desa.js` | `perangkatDesaCrud` | Perangkat Desa |
| `profil-desa.js` | `profilDesa` | Profil Desa |
| `kategori-barang.js` | `kategoriBarangCrud` | Kategori Barang |
| `lokasi.js` | `lokasiCrud` | Lokasi Barang |
| `barang.js` | `barangCrud` | Barang Inventaris |
| `peminjaman.js` | `peminjamanCrud` | Peminjaman Barang |
| `mutasi.js` | `mutasiCrud` | Mutasi / Buku Besar |
| `dashboard.js` | `dashboard` | Dashboard |
| `peta-desa.js` | `petaDesa` | Village Map |
| `bacaan-edukatif.js` | `bacaanEdukatif` | Bacaan Edukatif |
| `bacaan-detail.js` | `bacaanDetail` | Bacaan Detail |
| `artikel-crud.js` | `artikelCrud` | Artikel Management |
| `about.js` | `about` | About Page |

### `services/`
API communication layer. Each file exports an object with `list`, `create`, `update`, `remove` (and custom methods where applicable).

| File | Entity / Purpose |
|------|-----------------|
| `httpClient.js` | Base: `apiFetch()` (auto-unwrap) & `apiFetchJson()` (raw JSON) |
| `auth.js` | Auth — login, logout, token, headers |
| `kkApi.js` | Kartu Keluarga |
| `pendidikanApi.js` | Pendidikan |
| `masterFieldSuratApi.js` | Field Surat |
| `pendudukApi.js` | Penduduk |
| `kategoriSuratApi.js` | Kategori Surat |
| `dusunApi.js` | Dusun |
| `rwApi.js` | RW |
| `rtApi.js` | RT |
| `jabatanPerangkatApi.js` | Jabatan Perangkat |
| `perangkatDesaApi.js` | Perangkat Desa |
| `profilDesaApi.js` | Profil Desa |
| `kategoriBarangApi.js` | Kategori Barang |
| `lokasiApi.js` | Lokasi Barang |
| `barangApi.js` | Barang + stock actions |
| `peminjamanApi.js` | Peminjaman + return/cancel |
| `mutasiApi.js` | Mutasi (read-only) |
| `dashboardApi.js` | Dashboard data |
| `wilayahApi.js` | Wilayah (province/district) |
| `paperApi.js` | Paper / documents |

### `composables/`
Reusable stateful logic (Vue 3 `useXxx` convention). Spread into Alpine components.

| File | Purpose |
|------|---------|
| `useKKLookup.js` | Autocomplete KK lookup |
| `usePendidikanLookup.js` | Autocomplete Pendidikan lookup |
| `useBarangLookup.js` | Autocomplete Barang lookup |
| `useKategoriLookup.js` | Kategori select loader |
| `useLokasiLookup.js` | Lokasi select loader |
| `useWilayahLookup.js` | Wilayah select loader |

### `mappers/`
Data transformation between API and form. Each exports `emptyForm()`, `mapItemToForm()`, `buildPayload()`.

| File | Entity |
|------|--------|
| `kkMapper.js` | Kartu Keluarga |
| `pendidikanMapper.js` | Pendidikan |
| `masterFieldSuratMapper.js` | Field Surat |
| `pendudukMapper.js` | Penduduk |
| `kategoriSuratMapper.js` | Kategori Surat |
| `dusunMapper.js` | Dusun |
| `rwMapper.js` | RW |
| `rtMapper.js` | RT |
| `jabatanPerangkatMapper.js` | Jabatan Perangkat |
| `perangkatDesaMapper.js` | Perangkat Desa |
| `paperMapper.js` | Paper / documents |
| `kategoriBarangMapper.js` | Kategori Barang |
| `lokasiMapper.js` | Lokasi Barang |
| `barangMapper.js` | Barang Inventaris |
| `peminjamanMapper.js` | Peminjaman (incl. details array) |

### `components/`
Specific Alpine components (not Blade).

| File | Alpine Name | Purpose |
|------|-------------|---------|
| `login.js` | `loginForm` | Login form |
| `surat-wizard.js` | `suratWizard` | Surat wizard (4 steps) |

### `utils/`
Pure utility functions, no state.

| File | Exports |
|------|---------|
| `pagination.js` | `normalizePaginatedResponse()`, `normalizeCollectionResponse()` |
| `validation.js` | `isRequired()`, `isEmail()`, `isNik()` |
| `date.js` | `formatDate()`, `dateToInputValue()` |
| `format.js` | `genderLabel()`, `statusBadge()`, `statusLabel()` |
| `inputMode.js` | `inputModeLabel()`, `inputModeBadge()` |
| `number.js` | `toNullableNumber()` |

---

## 📁 `bruno/CURUG_API_DOC/`

API documentation in **Bruno** format. Use the Bruno desktop app or read the HTML export.

```
bruno/CURUG_API_DOC/
├── Auth/                          # POST /login
├── Data Desa/                     # KK, Pendidikan, Penduduk, Jabatan Perangkat,
│                                  # Perangkat Desa, Profil Desa, Wilayah
├── Data Inventaris/               # Barang, Kategori Barang, Lokasi, Mutasi, Peminjaman
├── Data Surat/                    # Master Field Surat, Surat Wizard Steps
├── Testing/Surat/                 # Endpoint testing
├── environments/                  # Environment variables (fill in)
├── opencollection.yml
└── CURUG_API_DOC.html            # HTML export (read without Bruno)
```

Each CRUD directory typically contains: `Create.yml` (POST), `Index.yml` (GET list), `Show by ID.yml` (GET single), `Update by ID.yml` (PUT), `Delete by ID.yml` (DELETE).

---

## 🚀 CRUD Flow (Common Pattern)

```
Blade (index.blade.php)
  └── x-data="xxxCrud"  →  JS (pages/xxx.js)
                              ├── services/xxxApi.js  →  HTTP call
                              ├── mappers/xxxMapper.js  →  transform data
                              └── composables/useXxx.js  →  shared logic
```

1. `index.blade.php` — `x-data="xxxCrud"` activates the Alpine component
2. `pages/xxx.js` — `load()` calls API via service
3. `services/xxxApi.js` — `apiFetch()` / `apiFetchJson()` from `httpClient.js`
4. `mappers/xxxMapper.js` — `emptyForm()`, `mapItemToForm()`, `buildPayload()`
5. `utils/pagination.js` — `normalizePaginatedResponse()` for pagination parsing

---

## 📐 Naming Conventions

| Layer | Convention | Example |
|-------|-----------|---------|
| Blade view | `*.blade.php` | `layouts/app.blade.php` |
| Blade component | kebab-case | `master-data-toolbar.blade.php` |
| Form partial | `form-*.blade.php` (complex), `form.blade.php` (simple) | `form-identitas.blade.php` |
| Service | `xxxApi.js` | `kkApi.js` |
| Page/Alpine | `xxx.js` | `kk.js` |
| Composable | `useXxx.js` | `useKKLookup.js` |
| Mapper | `xxxMapper.js` | `kkMapper.js` |
| Utility | `xxx.js` | `pagination.js` |
| Route | `master-data.{entity}.index` | `master-data.kk.index` |

---

## 📂 Where to Create New Files

| If you want to... | Create file in... |
|---|---|
| Add a new Blade page/view | `resources/views/{module-name}/` |
| Add a reusable UI component | `resources/views/components/` |
| Add form fields | `resources/views/components/form/` |
| Add an Alpine page component | `resources/js/pages/{name}.js` |
| Add an API service | `resources/js/services/{name}Api.js` |
| Add a mapper | `resources/js/mappers/{name}Mapper.js` |
| Add a composable (shared logic) | `resources/js/composables/use{Name}.js` |
| Add a utility function | `resources/js/utils/{name}.js` |
| Document an API endpoint | `bruno/CURUG_API_DOC/{category}/` |

---



