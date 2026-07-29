# Project Resource Structure, overview, reference dan convension

> **Purpose:** developer reference for navigating all frontend resources.  
> **Do not update this file** update will be done manually by developer.

---

## Tech Stack

| Layer | Technology | Location |
|-------|-----------|----------|
| Backend | Laravel | `app/`, `routes/` |
| Frontend | Alpine.js | `resources/js/` |
| Templating | Blade | `resources/views/` |
| Bundler | Vite | `vite.config.js` |

---

## 1. Resources Map (`resources/views/`)

### Layout & Shell

| Path | Type | Purpose |
|------|------|---------|
| `layouts/app.blade.php` | Layout | Main logged-in layout (sidebar, navbar, footer, @yield) |
| `layouts/auth.blade.php` | Layout | Auth layout (login, no sidebar) |
| `partials/sidebar.blade.php` | Partial | Sidebar navigation |
| `partials/navbar.blade.php` | Partial | Top navbar |
| `partials/footer.blade.php` | Partial | Footer |
| `partials/head.blade.php` | Partial | `<head>` meta, title, CSS |

### Shared Components (`components/`)

| Path | Usage | Purpose |
|------|-------|---------|
| `alert.blade.php` | `x-data` reads Alpine `error`/`success` | Success/error notification |
| `master-data-toolbar.blade.php` | Props: title, description, searchPlaceholder, buttonLabel, searchWidth | Generic CRUD toolbar |
| `modal.blade.php` | Props: show (default: `showModal`), title, maxWidth | Generic modal |
| `confirm-dialog.blade.php` | Props: show (default: `confirmShow`), title, confirm, danger | Delete confirmation |
| `pagination.blade.php` | Reads Alpine `meta.current_page`, `.last_page`, `.total` | Pagination nav |
| `step-indicator.blade.php` | Reads Alpine `step` | Surat wizard steps |
| `form/input.blade.php` | Props: label, model, type, placeholder, required, hint, error | Generic input |
| `form/select.blade.php` | Props: label, model, options, placeholder, nullable, required, hint, error | Generic select |
| `form/textarea.blade.php` | Props: label, model, placeholder, required, rows, hint, error | Generic textarea |

### Standalone Pages

| Path | Purpose |
|------|---------|
| `auth/login.blade.php` | Login page |
| `dashboard/index.blade.php` + `partials/` | Dashboard (charts: agama, pekerjaan, pendidikan, umur, profile-header, stat-cards) |
| `about/index.blade.php` | About page |
| `bacaan/index.blade.php` | Bacaan edukatif list |
| `bacaan/show.blade.php` | Bacaan edukatif detail |
| `peta-desa/index.blade.php` | Village map |
| `manajemen-konten/artikel/index.blade.php` + `partials/` | Artikel CRUD management |

### CRUD Modules (pattern: `index.blade.php` + `partials/table.blade.php` + `partials/form*.blade.php`)

All modules below follow the same Blade structure in their respective subdirectory under `resources/views/`.

---

## 2. Cross-Reference: Feature → All Layers

Each feature spans **Blade view** + **Alpine page** + **API service** + **Mapper**. This table maps everything in one place.

| Entity | View dir (`views/`) | Alpine (`pages/`) | Service (`services/`) | Mapper (`mappers/`) | API Endpoint |
|--------|--------------------|-------------------|-----------------------|---------------------|--------------|
| Kartu Keluarga | `master-data/kk/` | `kk.js` → `kkCrud` | `kkApi.js` | `kkMapper.js` | `/api/kk` |
| Pendidikan | `master-data/pendidikan/` | `pendidikan.js` → `pendidikanCrud` | `pendidikanApi.js` | `pendidikanMapper.js` | `/api/pendidikan` |
| Field Surat | `master-data/master-field-surat/` | `master-field-surat.js` → `masterFieldSurat` | `masterFieldSuratApi.js` | `masterFieldSuratMapper.js` | `/api/srt-master-field-surat` |
| Penduduk | `master-data/penduduk/` | `penduduk.js` → `pendudukCrud` | `pendudukApi.js` | `pendudukMapper.js` | `/api/penduduk` |
| Kategori Surat | `master-data/kategori-surat/` | `kategori-surat.js` → `kategoriSuratCrud` | `kategoriSuratApi.js` | `kategoriSuratMapper.js` | `/api/srt-kategori-surat` |
| Dusun | `master-data/dusun/` | `dusun.js` → `dusunCrud` | `dusunApi.js` | `dusunMapper.js` | `/api/ref-dusun` |
| RW | `master-data/rw/` | `rw.js` → `rwCrud` | `rwApi.js` | `rwMapper.js` | `/api/ref-rw` |
| RT | `master-data/rt/` | `rt.js` → `rtCrud` | `rtApi.js` | `rtMapper.js` | `/api/ref-rt` |
| Jabatan Perangkat | `master-data/jabatan-perangkat/` | `jabatan-perangkat.js` → `jabatanPerangkatCrud` | `jabatanPerangkatApi.js` | `jabatanPerangkatMapper.js` | `/api/ref-jabatan-perangkat` |
| Perangkat Desa | `master-data/perangkat-desa/` | `perangkat-desa.js` → `perangkatDesaCrud` | `perangkatDesaApi.js` | `perangkatDesaMapper.js` | `/api/ref-perangkat-desa` |
| Profil Desa | `master-data/profil-desa/` | `profil-desa.js` → `profilDesa` | `profilDesaApi.js` | — | `/api/ref-profil-desa` |
| Kategori Barang | `inventaris/kategori-barang/` | `kategori-barang.js` → `kategoriBarangCrud` | `kategoriBarangApi.js` | `kategoriBarangMapper.js` | `/api/inv-kategori-barang` |
| Lokasi Barang | `inventaris/lokasi/` | `lokasi.js` → `lokasiCrud` | `lokasiApi.js` | `lokasiMapper.js` | `/api/inv-lokasi` |
| Barang Inventaris | `inventaris/barang/` | `barang.js` → `barangCrud` | `barangApi.js` *(+stock actions)* | `barangMapper.js` | `/api/inv-barang` |
| Peminjaman | `inventaris/peminjaman/` | `peminjaman.js` → `peminjamanCrud` | `peminjamanApi.js` *(+return/cancel)* | `peminjamanMapper.js` *(+details)* | `/api/inv-peminjaman` |
| Mutasi | `inventaris/mutasi/` | `mutasi.js` → `mutasiCrud` | `mutasiApi.js` (read-only) | — | `/api/inv-mutasi` |
| Artikel | `manajemen-konten/artikel/` | `artikel-crud.js` → `artikelCrud` | — | — | — |

### Other Pages (read-only / non-CRUD)

| View dir | Alpine page | Service(s) | Purpose |
|----------|------------|------------|---------|
| `dashboard/` | `dashboard.js` → `dashboard` | `dashboardApi.js` | Dashboard homepage |
| `peta-desa/` | `peta-desa.js` → `petaDesa` | `wilayahApi.js` | Village map |
| `bacaan/` | `bacaan-edukatif.js` → `bacaanEdukatif` / `bacaan-detail.js` → `bacaanDetail` | `paperApi.js` | Bacaan edukatif |
| `about/` | `about.js` → `about` | — | About page |

### Surat Wizard (special multi-step, not CRUD)

| Layer | File | Role |
|-------|------|------|
| View | `surat/index.blade.php` | Main wizard container (4 steps) |
| Steps | `surat/steps/pilih-jenis-surat.blade.php` | Step 1: choose letter type |
| Steps | `surat/steps/isi-nik.blade.php` | Step 2: enter NIK |
| Steps | `surat/steps/isi-data-manual.blade.php` | Step 3: fill additional data |
| Steps | `surat/steps/preview-download.blade.php` | Step 4: preview & download |
| Alpine | `components/surat-wizard.js` → `suratWizard` | Wizard state machine |

---

## 3. `resources/js/` — JavaScript Layers

### Entry Point

**`app.js`** — Registers all Alpine components (via `Alpine.data()`), plugins (`@alpinejs/collapse`), global services (`Auth`, `barangApi`, `peminjamanApi`, `mutasiApi`), and `$formatDate` magic.

### Other Services (no dedicated Blade page)

| File | Purpose |
|------|---------|
| `httpClient.js` | Base: `apiFetch()` (auto-unwrap) + `apiFetchJson()` (raw) |
| `auth.js` | Login, logout, token, headers (global `window.Auth`) |
| `wilayahApi.js` | Wilayah (province/district select cascades) |
| `appInfoApi.js` | App info / metadata |

### Composables (`composables/`)
Reusable logic, spread into Alpine components. Convention: `useXxx.js`.

| File | Purpose |
|------|---------|
| `useKKLookup.js` | Autocomplete KK lookup |
| `usePendidikanLookup.js` | Autocomplete Pendidikan lookup |
| `useBarangLookup.js` | Autocomplete Barang lookup (for peminjaman form) |
| `useKategoriLookup.js` | Load kategori options for select |
| `useLokasiLookup.js` | Load lokasi options for select |
| `useWilayahLookup.js` | Wilayah cascading select |

### Utilities (`utils/`)
Pure functions, no state.

| File | Exports |
|------|---------|
| `pagination.js` | `normalizePaginatedResponse()`, `normalizeCollectionResponse()` |
| `validation.js` | `isRequired()`, `isEmail()`, `isNik()` |
| `date.js` | `formatDate()`, `dateToInputValue()` |
| `format.js` | `genderLabel()`, `statusBadge()`, `statusLabel()` |
| `inputMode.js` | `inputModeLabel()`, `inputModeBadge()` |
| `number.js` | `toNullableNumber()` |

---

## 4. CRUD Architecture (Standard Flow)

```
Blade: index.blade.php
  └── x-data="xxxCrud" ──→ JS: pages/xxx.js
                              ├── .load()    → services/xxxApi.js → HTTP
                              ├── .save()    → services/xxxApi.js → HTTP
                              ├── .remove()  → services/xxxApi.js → HTTP
                              ├── mappers/xxxMapper.js  (emptyForm, mapItemToForm, buildPayload)
                              └── composables/useXxx.js  (shared state logic)
```

All CRUD modules (16 entities) follow this exact pattern.

---

## 5. Naming Conventions

| Layer | Convention | Example |
|-------|-----------|---------|
| Blade view | `*.blade.php` | `layouts/app.blade.php` |
| Blade component | kebab-case | `master-data-toolbar.blade.php` |
| Form partial | `form-*.blade.php` (complex), `form.blade.php` (simple) | `form-identitas.blade.php` |
| Service | `{entity}Api.js` | `kkApi.js` |
| Alpine page | `{entity}.js` | `kk.js` |
| Alpine data name | `{entity}Crud` (camelCase) | `kkCrud` |
| Mapper | `{entity}Mapper.js` | `kkMapper.js` |
| Composable | `use{Name}.js` | `useKKLookup.js` |
| Utility | `{name}.js` | `pagination.js` |
| Route | `master-data.{entity}.index` | `master-data.kk.index` |

---

## 6. API Documentation (`bruno/CURUG_API_DOC/`)

Bruno collection. Open with Bruno desktop app or read `CURUG_API_DOC.html`.

```
bruno/CURUG_API_DOC/
├── Auth/                          POST /login
├── Data Desa/                     KK, Pendidikan, Penduduk, Jabatan Perangkat, Perangkat Desa, Profil Desa, Wilayah
├── Data Inventaris/               Barang, Kategori Barang, Lokasi, Mutasi, Peminjaman
├── Data Surat/                    Master Field Surat, Surat Wizard Steps
├── Testing/Surat/                 Endpoint testing
├── environments/                  (empty — fill before use)
├── opencollection.yml             Main collection file
└── CURUG_API_DOC.html            HTML export (read-only)
```

Each CRUD directory: `Create.yml` (POST) · `Index.yml` (GET list) · `Show by ID.yml` (GET single) · `Update by ID.yml` (PUT) · `Delete by ID.yml` (DELETE).

---

## 7. Where to Create New Files

| Goal | File path |
|------|-----------|
| New Blade page/view | `resources/views/{module-name}/` |
| Reusable UI component | `resources/views/components/` |
| Form field | `resources/views/components/form/` |
| Alpine page component | `resources/js/pages/{name}.js` |
| API service | `resources/js/services/{name}Api.js` |
| Mapper | `resources/js/mappers/{name}Mapper.js` |
| Composable | `resources/js/composables/use{Name}.js` |
| Utility function | `resources/js/utils/{name}.js` |
| API documentation | `bruno/CURUG_API_DOC/{category}/` |

---

## 8. Rule of Thumb

- **Reusable UI** → Blade component (`resources/views/components/`)
- **DOM manipulation** → Alpine component (`resources/js/pages/` or `resources/js/components/`)
- **Network/API logic** → Service (`resources/js/services/`)
- **Data transformation** → Mapper (`resources/js/mappers/`)
- **Pure functions** → Utility (`resources/js/utils/`)
- **Shared state** → Composable (`resources/js/composables/`)
- **Pages orchestrate; they don't own every responsibility.**



