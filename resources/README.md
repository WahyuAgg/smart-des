# Project Resource Structure

Proyek ini menggunakan **Laravel** (backend) + **Alpine.js** (frontend interaktivitas) + **Vite** (bundler).  
Seluruh UI diorganisir dalam dua direktori utama: `resources/views/` (Blade template) dan `resources/js/` (JavaScript/Alpine).

## Purpose

This document is meant to help future maintainers quickly locate the correct file type and avoid mixing concerns.

---

## 📁 `resources/views/` — Blade Templates

### `layouts/`
Template layout utama yang dipakai oleh semua halaman.

| File | Fungsi |
|------|--------|
| `app.blade.php` | Layout utama untuk halaman yang sudah login. Menyusun sidebar, navbar, footer, dan yield section (`title`, `content`, dll). |
| `auth.blade.php` | Layout khusus halaman autentikasi (login), tanpa sidebar. |

### `components/`
Komponen Blade **reusable** yang bisa dipakai lintas halaman.  
Cara pakai: `<x-nama-komponen :props="..." />` atau `@include('components.nama-komponen')`.

| File | Fungsi |
|------|--------|
| `alert.blade.php` | Notifikasi sukses/error. Mengakses `error` dan `success` dari Alpine scope. |
| `master-data-toolbar.blade.php` | Toolbar generik untuk halaman master-data: judul, deskripsi, search input, tombol tambah. **Props:** `title`, `description`, `searchPlaceholder`, `buttonLabel`, `searchWidth`. |
| `modal.blade.php` | Modal dialog generik. **Props:** `show` (default: `showModal`), `title`, `maxWidth`. |
| `confirm-dialog.blade.php` | Dialog konfirmasi untuk aksi hapus. **Props:** `show` (default: `confirmShow`), `title`, `confirm`, `danger`. |
| `pagination.blade.php` | Navigasi halaman. Mengakses `meta.current_page`, `meta.last_page`, `meta.total` dari Alpine. |
| `step-indicator.blade.php` | Indikator langkah untuk wizard surat (4 langkah). Mengakses `step` dari Alpine. |
| `form/input.blade.php` | Input teks generik. **Props:** `label`, `model`, `type`, `placeholder`, `required`, `hint`, `error`. |
| `form/select.blade.php` | Select dropdown generik. **Props:** `label`, `model`, `options`, `placeholder`, `nullable`, `required`, `hint`, `error`. |
| `form/textarea.blade.php` | Textarea generik. **Props:** `label`, `model`, `placeholder`, `required`, `rows`, `hint`, `error`. |

### `master-data/`
Halaman CRUD untuk setiap entitas master data. **Semua pakai pola modular**:
- `index.blade.php` — halaman utama, wiring komponen dan partials
- `partials/table.blade.php` — tabel data + pagination
- `partials/form.blade.php` (atau `form-*.blade.php`) — form input di dalam modal

| Direktori | Entitas | API Endpoint | Catatan |
|-----------|---------|-------------|---------|
| `kk/` | Kartu Keluarga | `/api/kk` | Form sederhana (2 field) |
| `pendidikan/` | Tingkat Pendidikan | `/api/pendidikan` | Form sederhana (1 field) |
| `master-field-surat/` | Field Surat | `/api/srt-master-field-surat` | Form sedang |
| `penduduk/` | Penduduk | `/api/penduduk` | Form kompleks, dipisah jadi 5 partial: `form-identitas`, `form-keluarga`, `form-kontak`, `form-alamat`, `form-lookup` |

### `partials/`
Fragment layout yang **spesifik** dan hanya dipasang sekali di layout (`app.blade.php`).

| File | Fungsi |
|------|--------|
| `sidebar.blade.php` | Sidebar navigasi — menu utama + master data dropdown. |
| `navbar.blade.php` | Top navigation bar. |
| `footer.blade.php` | Footer halaman. |
| `head.blade.php` | Elemen `<head>` — meta, title, asset CSS. |

### `auth/`
Halaman autentikasi.

| File | Fungsi |
|------|--------|
| `login.blade.php` | Halaman login. |

### `surat/`
Wizard multi-langkah untuk pengajuan surat, **bukan CRUD biasa**.

| File | Fungsi |
|------|--------|
| `index.blade.php` | Halaman utama wizard — wiring 4 step. |
| `steps/pilih-jenis-surat.blade.php` | Langkah 1: pilih jenis surat. |
| `steps/isi-nik.blade.php` | Langkah 2: isi NIK penduduk. |
| `steps/isi-data-manual.blade.php` | Langkah 3: isi data tambahan. |
| `steps/preview-download.blade.php` | Langkah 4: pratinjau dan unduh surat. |

---

## 📁 `resources/js/` — JavaScript / Alpine.js

### `app.js`
**Entry point.** Mendaftarkan semua komponen Alpine dan service global.

### `pages/`
Halaman CRUD dalam bentuk **Alpine component**.
Setiap file mengekspor satu fungsi pabrik (`() => ({...})`) yang didaftarkan di `app.js` via `Alpine.data()`.

| File | Nama Alpine | Entitas |
|------|-------------|---------|
| `kk.js` | `kkCrud` | Kartu Keluarga |
| `pendidikan.js` | `pendidikanCrud` | Pendidikan |
| `master-field-surat.js` | `masterFieldSurat` | Field Surat |
| `penduduk.js` | `pendudukCrud` | Penduduk |

### `services/`
Layer **API communication**. Setiap file berisi object dengan method `list`, `create`, `update`, `remove`.

| File | Fungsi |
|------|--------|
| `httpClient.js` | Dasar: `apiFetch()` (unwrap otomatis) dan `apiFetchJson()` (raw JSON). |
| `auth.js` | Autentikasi — login, logout, token, headers. |
| `kkApi.js` | CRUD KK via `/api/kk` |
| `pendidikanApi.js` | CRUD Pendidikan via `/api/pendidikan` |
| `masterFieldSuratApi.js` | CRUD Field Surat via `/api/srt-master-field-surat` |
| `pendudukApi.js` | CRUD Penduduk via `/api/penduduk` |

### `composables/`
**Composable** — fungsi yang mengembalikan state + method untuk di-*spread* ke Alpine component.  
Mengikuti konvensi Vue 3: `useXxx`.

| File | Fungsi |
|------|--------|
| `useKKLookup.js` | Autocomplete lookup KK (search, dropdown, select). |
| `usePendidikanLookup.js` | Autocomplete lookup Pendidikan (search, dropdown, select). |

### `mappers/`
**Mapper** — fungsi untuk transformasi data antara API dan form.

| File | Fungsi |
|------|--------|
| `kkMapper.js` | `emptyForm()`, `mapItemToForm()`, `buildPayload()` |
| `pendidikanMapper.js` | `emptyForm()`, `mapItemToForm()`, `buildPayload()` |
| `masterFieldSuratMapper.js` | `emptyForm()`, `mapItemToForm()`, `buildPayload()` |
| `pendudukMapper.js` | `emptyForm()`, `mapItemToForm()`, `buildPayload()` |

### `utils/`
Fungsi utilitas murni, tanpa state.

| File | Fungsi |
|------|--------|
| `pagination.js` | `normalizePaginatedResponse()`, `normalizeCollectionResponse()` — normalisasi respons paginasi. |
| `validation.js` | `isRequired()`, `isEmail()`, `isNik()`. |
| `date.js` | `formatDate()`, `dateToInputValue()`. |
| `format.js` | `genderLabel()`, `statusBadge()`, `statusLabel()`. |
| `inputMode.js` | `inputModeLabel()`, `inputModeBadge()`. |
| `number.js` | `toNullableNumber()`. |

### `components/`
Komponen Alpine **spesifik** (bukan komponen Blade).

| File | Fungsi |
|------|--------|
| `login.js` | Form login. |
| `surat-wizard.js` | Wizard pengajuan surat (4 langkah). |

---

## 📁 `bruno/CURUG_API_DOC/`

Dokumentasi API lengkap dalam format **Bruno** (API client).  
Gunakan Bruno untuk menguji endpoint tanpa perlu membaca kode backend.

```
bruno/CURUG_API_DOC/
├── KK/                  # CRUD Kartu Keluarga
├── Pendidikan/          # CRUD Pendidikan
├── Penduduk/            # CRUD Penduduk
├── Master Field Surat/  # CRUD Master Field Surat
├── CURUG_API_DOC.yml    # Dokumen utama Bruno
└── CURUG_API_DOC.html   # Export HTML (baca tanpa Bruno)
```

Setiap direktori berisi file `.yml` untuk setiap method HTTP:
- `Create.yml` — POST
- `Get all, search, pagination.yml` — GET (list)
- `Get by ID.yml` — GET (single)
- `Update by ID.yml` — PUT
- `Delete by ID.yml` — DELETE

---

## 📐 Konvensi Penamaan

### Blade Views
- **Layout:** `*.blade.php` → `layouts/app.blade.php`
- **Komponen:** kebab-case → `master-data-toolbar.blade.php`
- **Partial:** `*.blade.php` → `partials/table.blade.php`
- **Form partial:** `form-*.blade.php` untuk form kompleks, `form.blade.php` untuk form sederhana

### JavaScript
- **Service:** `xxxApi.js` → `kkApi.js`, `pendudukApi.js`
- **Page/Alpine:** `xxx.js` → `kk.js`, `penduduk.js`
- **Composable:** `useXxx.js` → `useKKLookup.js`
- **Mapper:** `xxxMapper.js` → `kkMapper.js`
- **Utility:** `xxx.js` → `pagination.js`, `validation.js`

### Route Names
```
master-data.{entity}.index
```
Contoh: `master-data.kk.index`, `master-data.penduduk.index`, `master-data.pendidikan.index`.

---

## 🚀 Alur CRUD (Pola Umum)

```
Blade (index.blade.php)
  └── x-data="xxxCrud"  →  JS (pages/xxx.js)
                              ├── services/xxxApi.js  →  HTTP call
                              ├── mappers/xxxMapper.js  →  transform data
                              └── composables/useXxx.js  →  shared logic
```

1. `index.blade.php` — `x-data="xxxCrud"` mengaktifkan Alpine component
2. `pages/xxx.js` — method `load()` memanggil API via service
3. `services/xxxApi.js` — `apiFetch()` / `apiFetchJson()` dari `httpClient.js`
4. `mappers/xxxMapper.js` — `emptyForm()`, `mapItemToForm()`, `buildPayload()`
5. `utils/pagination.js` — `normalizePaginatedResponse()` untuk parsing pagination

# Rule of thumb
- Prefer reusable components over duplicated markup.
- Keep DOM manipulation inside components.
- Keep network/API logic inside services.
- Keep data transformation inside mappers.
- Keep small, pure utility functions inside utils.
- Let pages orchestrate; don't let them own every responsibility.

# Rule of Modification

- If theres modification to the code, update this file together with the related files.
- If this documentation becomes outdated, please update this file.

# summary of current resources complete structure


│   README.md
│   
├───css
│       app.css
│       
├───js
│   │   app.js
│   │   bootstrap.js
│   │   
│   ├───components
│   │       login.js
│   │       surat-wizard.js
│   │       
│   ├───composables
│   │       useKKLookup.js
│   │       usePendidikanLookup.js
│   │       
│   ├───mappers
│   │       kkMapper.js
│   │       masterFieldSuratMapper.js
│   │       pendidikanMapper.js
│   │       pendudukMapper.js
│   │       
│   ├───pages
│   │       kk.js
│   │       master-field-surat.js
│   │       pendidikan.js
│   │       penduduk.js
│   │       
│   ├───services
│   │       auth.js
│   │       httpClient.js
│   │       kkApi.js
│   │       masterFieldSuratApi.js
│   │       pendidikanApi.js
│   │       pendudukApi.js
│   │       
│   └───utils
│           date.js
│           format.js
│           inputMode.js
│           number.js
│           pagination.js
│           validation.js
│           
└───views
    ├───auth
    │       login.blade.php
    │       
    ├───components
    │   │   alert.blade.php
    │   │   confirm-dialog.blade.php
    │   │   master-data-toolbar.blade.php
    │   │   modal.blade.php
    │   │   pagination.blade.php
    │   │   step-indicator.blade.php
    │   │   
    │   └───form
    │           input.blade.php
    │           select.blade.php
    │           textarea.blade.php
    │           
    ├───layouts
    │       app.blade.php
    │       auth.blade.php
    │       
    ├───master-data
    │   ├───kk
    │   │   │   index.blade.php
    │   │   │   
    │   │   └───partials
    │   │           form.blade.php
    │   │           table.blade.php
    │   │           
    │   ├───master-field-surat
    │   │   │   index.blade.php
    │   │   │   
    │   │   └───partials
    │   │           form.blade.php
    │   │           table.blade.php
    │   │           
    │   ├───pendidikan
    │   │   │   index.blade.php
    │   │   │   
    │   │   └───partials
    │   │           form.blade.php
    │   │           table.blade.php
    │   │           
    │   └───penduduk
    │       │   index.blade.php
    │       │   
    │       └───partials
    │               form-alamat.blade.php
    │               form-identitas.blade.php
    │               form-keluarga.blade.php
    │               form-kontak.blade.php
    │               form-lookup.blade.php
    │               table.blade.php
    │               
    ├───partials
    │       footer.blade.php
    │       head.blade.php
    │       navbar.blade.php
    │       sidebar.blade.php
    │       
    └───surat
        │   index.blade.php
        │   
        └───steps
                isi-data-manual.blade.php
                isi-nik.blade.php
                pilih-jenis-surat.blade.php
                preview-download.blade.php