# Planning Integrasi Sistem Inventaris Desa — Frontend

## 1. Ringkasan

Mengintegrasikan modul **Data Inventaris** (API Bruno) ke dalam frontend Laravel + Alpine.js yang sudah ada, mengikuti pola yang sudah dipakai di modul `master-data` (KK, Pendidikan, Penduduk, dll).

Dokumentasi: bruno\CURUG_API_DOC\Data Inventaris

---

## 2. Entitas & API Endpoint

| Entitas | API Prefix | Kategori UI | Catatan |
|---------|-----------|-------------|---------|
| **Barang** | `inv-barang` | CRUD + Aksi Khusus | Halaman utama inventaris: daftar barang, tambah/edit, stok. Aksi: pengadaan, hilang, ketemu, opname, hapus stok. |
| **Kategori Barang** | `inv-kategori-barang` | CRUD Sederhana | Referensi, mirip seperti Pendidikan. |
| **Lokasi** | `inv-lokasi` | CRUD Sederhana | Referensi, mirip seperti Pendidikan. |
| **Peminjaman** | `inv-peminjaman` | CRUD + Aksi Khusus | Header-detail: peminjam + barang dipinjam. Aksi: kembalikan, batalkan. |
| **Mutasi** | `inv-mutasi` | Read-only (Index/Show) | Buku besar stock ledger, hanya lihat riwayat. |
| **Detail Peminjaman** | `inv-detail-peminjaman` | (via Peminjaman) | Tidak perlu halaman sendiri — dikelola lewat form Peminjaman. |
| **Detail Mutasi** | `inv-detail-mutasi` | (via Mutasi) | Tidak perlu halaman sendiri. |

---

## 3. Struktur Direktori Baru

### Blade Views

```
resources/views/
├── inventaris/                          # ← NEW: root untuk semua halaman inventaris
│   ├── barang/
│   │   ├── index.blade.php              # Daftar barang + toolbar
│   │   ├── detail.blade.php             # Halaman detail 1 barang (riwayat, stok)
│   │   └── partials/
│   │       ├── table.blade.php          # Tabel daftar barang
│   │       ├── form.blade.php           # Form tambah/edit barang
│   │       ├── modal-pengadaan.blade.php # Modal aksi pengadaan stok
│   │       ├── modal-opname.blade.php    # Modal aksi opname
│   │       ├── modal-hilang.blade.php    # Modal aksi hilang
│   │       └── modal-ketemu.blade.php    # Modal aksi ketemu
│   │
│   ├── kategori-barang/
│   │   ├── index.blade.php              # CRUD sederhana (mirip Pendidikan)
│   │   └── partials/
│   │       ├── table.blade.php
│   │       └── form.blade.php
│   │
│   ├── lokasi/
│   │   ├── index.blade.php              # CRUD sederhana (mirip Pendidikan)
│   │   └── partials/
│   │       ├── table.blade.php
│   │       └── form.blade.php
│   │
│   ├── peminjaman/
│   │   ├── index.blade.php              # Daftar peminjaman
│   │   ├── detail.blade.php             # Detail 1 peminjaman (barang yg dipinjam)
│   │   └── partials/
│   │       ├── table.blade.php
│   │       ├── form.blade.php           # Form header + dynamic rows barang
│   │       └── modal-batal.blade.php    # Konfirmasi pembatalan
│   │
│   └── mutasi/
│       ├── index.blade.php              # Buku besar mutasi (read-only)
│       ├── show.blade.php               # Detail 1 mutasi
│       └── partials/
│           ├── table.blade.php
│           └── filter.blade.php         # Filter: jenis, tanggal, barang
```

### JavaScript / Alpine

```
resources/js/
├── pages/
│   ├── (existing: kk.js, pendidikan.js, penduduk.js, ...)
│   ├── barang.js                        # ← NEW
│   ├── kategori-barang.js               # ← NEW
│   ├── lokasi.js                        # ← NEW
│   ├── peminjaman.js                    # ← NEW
│   └── mutasi.js                        # ← NEW
│
├── services/
│   ├── (existing: kkApi.js, pendudukApi.js, ...)
│   ├── barangApi.js                     # ← NEW
│   ├── kategoriBarangApi.js             # ← NEW
│   ├── lokasiApi.js                     # ← NEW
│   ├── peminjamanApi.js                 # ← NEW
│   └── mutasiApi.js                     # ← NEW
│
├── mappers/
│   ├── (existing: kkMapper.js, ...)
│   ├── barangMapper.js                  # ← NEW
│   ├── kategoriBarangMapper.js          # ← NEW
│   ├── lokasiMapper.js                  # ← NEW
│   ├── peminjamanMapper.js              # ← NEW
│   └── mutasiMapper.js                  # ← NEW
│
├── composables/
│   ├── (existing: useKKLookup.js, usePendidikanLookup.js)
│   ├── useBarangLookup.js               # ← NEW: autocomplete barang
│   └── useKategoriLokasiLookup.js       # ← NEW: lookup kategori & lokasi (bisa dipisah)
│
└── utils/
    └── (existing — mungkin tambah formatInventory.js untuk status badge dll)
```

---

## 4. Reusable Components — Yang Dipakai & Yang Perlu Ditambah

### Komponen yang SUDAH ADA dan bisa dipakai ulang

| Komponen | Digunakan di | Catatan |
|----------|-------------|---------|
| `x-master-data-toolbar` | Semua halaman CRUD | Judul, search, tombol tambah — cocok untuk Barang, Kategori, Lokasi, Peminjaman |
| `x-modal` | Semua halaman CRUD | Form input di dalam modal |
| `x-confirm-dialog` | Semua halaman hapus | Juga bisa dipakai untuk konfirmasi batalkan peminjaman |
| `x-pagination` | Semua halaman index | Bisa dipakai via `@include` |
| `x-alert` | Semua halaman | Notifikasi sukses/error |
| `x-form.input` | Semua form | Input teks, number, date |
| `x-form.select` | Semua form | Dropdown — cocok untuk kategori_id, lokasi_id |
| `x-form.textarea` | Semua form | Untuk keterangan |

### Komponen Blade BARU yang perlu dibuat

| Komponen | Lokasi | Alasan |
|----------|--------|--------|
| `inventaris-toolbar` | `components/inventaris-toolbar.blade.php` | Sama seperti `master-data-toolbar` tapi dengan breadcrumb "Inventaris" bukan "Master Data". Bisa juga pakai master-data-toolbar dengan `slot` breadcrumb, tapi lebih bersih bikin komponen terpisah. |
| **Alternatif:** cukup gunakan `master-data-toolbar` yang sudah ada, ganti breadcrumb via prop. | — | Tidak perlu komponen baru — lebih hemat. |

**Keputusan:** Pakai ulang `x-master-data-toolbar` tanpa komponen baru. Breadcrumb bisa di-hardcode di masing-masing `index.blade.php`.

### Komponen Alpine KHUSUS yang perlu dibuat

| File | Fungsi |
|------|--------|
| `components/barang-detail.js` | Halaman detail barang — menampilkan info barang, stok, riwayat mutasi, peminjaman aktif |
| `components/peminjaman-detail.js` | Halaman detail peminjaman — menampilkan header + daftar barang |

---

## 5. Navigasi & Sidebar

### Struktur Sidebar Usulan

```
Sidebar:
├── Dashboard
├── Pengajuan Surat
├── Riwayat Surat
├── Inventaris Desa           ← NEW: dropdown collapsible (grup baru)
│   ├── Daftar Barang
│   ├── Kategori Barang
│   ├── Lokasi
│   ├── Peminjaman
│   └── Mutasi / Buku Besar
├── Master Data (dropdown)
│   ├── Field Surat
│   ├── KK
│   ├── Pendidikan
│   ├── Jenis Surat
│   ├── Jabatan Perangkat
│   ├── Perangkat Desa
│   └── Penduduk
```

### Implementasi di `sidebar.blade.php`

- Tambah grup collapsible baru **"Inventaris Desa"** dengan icon tersendiri (misal: kotak/box).
- Gunakan pola yang sama seperti grup **Master Data** (Alpine `x-data`, `x-show`, `x-collapse`).
- Tambah array `$inventarisMenu` di atas, isi dengan route baru.
- Route prefix: `inventaris.{entity}.index`

```php
$inventarisMenu = [
    ['label' => 'Daftar Barang', 'route' => 'inventaris.barang.index'],
    ['label' => 'Kategori Barang', 'route' => 'inventaris.kategori-barang.index'],
    ['label' => 'Lokasi', 'route' => 'inventaris.lokasi.index'],
    ['label' => 'Peminjaman', 'route' => 'inventaris.peminjaman.index'],
    ['label' => 'Mutasi / Buku Besar', 'route' => 'inventaris.mutasi.index'],
];
```

---

## 6. Route Web (web.php)

### Tambah grup route baru

```php
// Inventaris Routes
Route::prefix('inventaris')->name('inventaris.')->group(function () {
    Route::get('/barang', fn() => view('inventaris.barang.index'))->name('barang.index');
    Route::get('/barang/{id}', fn($id) => view('inventaris.barang.detail', ['id' => $id]))->name('barang.detail');
    Route::get('/kategori-barang', fn() => view('inventaris.kategori-barang.index'))->name('kategori-barang.index');
    Route::get('/lokasi', fn() => view('inventaris.lokasi.index'))->name('lokasi.index');
    Route::get('/peminjaman', fn() => view('inventaris.peminjaman.index'))->name('peminjaman.index');
    Route::get('/peminjaman/{id}', fn($id) => view('inventaris.peminjaman.detail', ['id' => $id]))->name('peminjaman.detail');
    Route::get('/mutasi', fn() => view('inventaris.mutasi.index'))->name('mutasi.index');
    Route::get('/mutasi/{id}', fn($id) => view('inventaris.mutasi.show', ['id' => $id]))->name('mutasi.show');
});
```

---

## 7. Pengelompokan Halaman — Kompleksitas

### Level 1: CRUD Sederhana (seperti Pendidikan)

**Kategori Barang** & **Lokasi**
- Form: 2 field (nama, keterangan)
- Table: 2-3 kolom
- Tidak ada aksi khusus
- Pola: 1 file index + 1 form + 1 table — **sama persis seperti Pendidikan**

### Level 2: CRUD Standar + Aksi Tambahan

**Barang**
- Form: banyak field (kode, nama, kategori, lokasi, satuan, tanggal, keterangan, jumlah)
- Table: kolom status stok, warna badge
- **Aksi tambahan:** tombol "Pengadaan", "Hilang", "Ketemu", "Opname", "Hapus Stok"
- Aksi-aksi ini berupa **modal kecil** yang hanya meminta jumlah + keterangan
- **Detail page:** halaman khusus menampilkan info barang + riwayat mutasi + peminjaman aktif

### Level 3: Header-Detail + Workflow

**Peminjaman**
- Form: header (nama peminjam, tanggal) + dynamic rows (pilih barang, jumlah)
- Table: status badge (dipinjam/dikembalikan/dibatalkan)
- **Aksi:** tombol "Kembalikan" dan "Batalkan" dengan konfirmasi
- **Detail page:** menampilkan header + daftar barang yang dipinjam + status pengembalian

### Level 4: Read-only

**Mutasi / Buku Besar**
- Hanya Index + Show
- Filter: jenis mutasi, range tanggal, barang_id
- Show: detail 1 mutasi + barang apa saja yang terlibat

---

## 8. Pola Implementasi per Halaman (Standarisasi)

### 8a. CRUD Sederhana (Kategori, Lokasi) — same as Pendidikan

```
Blade: inventaris/kategori-barang/index.blade.php
  └── x-data="kategoriBarangCrud"
       ├── @include('components.alert')
       ├── <x-master-data-toolbar ... />
       ├── @include('inventaris.kategori-barang.partials.table')
       ├── <x-modal> ... @include('inventaris.kategori-barang.partials.form') ... </x-modal>
       └── <x-confirm-dialog ... />
```

### 8b. CRUD + Aksi Khusus (Barang)

```
Blade: inventaris/barang/index.blade.php
  └── x-data="barangCrud"
       ├── @include('components.alert')
       ├── <x-master-data-toolbar ... />
       ├── @include('inventaris.barang.partials.table')
       ├── <x-modal> ... @include('inventaris.barang.partials.form') ... </x-modal>
       ├── @include('inventaris.barang.partials.modal-pengadaan')
       ├── @include('inventaris.barang.partials.modal-hilang')
       ├── @include('inventaris.barang.partials.modal-ketemu')
       ├── @include('inventaris.barang.partials.modal-opname')
       └── <x-confirm-dialog ... />
```

### 8c. Header-Detail (Peminjaman)

```
Blade: inventaris/peminjaman/index.blade.php
  └── x-data="peminjamanCrud"
       ├── @include('components.alert')
       ├── <x-master-data-toolbar ... />
       ├── @include('inventaris.peminjaman.partials.table')
       ├── <x-modal> ... @include('inventaris.peminjaman.partials.form') ... </x-modal>
       ├── @include('inventaris.peminjaman.partials.modal-batal')
       └── <x-confirm-dialog ... />
```

### 8d. Aksi Kembalikan (Peminjaman)

Aksi "Kembalikan" bisa berupa:
1. **Modal inline** di halaman index — cukup input tanggal_kembali
2. **Halaman detail** — form pengembalian per barang (jumlah_kembali, jumlah_hilang)

Saran: Gunakan **halaman detail** (`inventaris/peminjaman/detail.blade.php`) untuk pengembalian yang lebih granular.

---

## 9. API Services yang Perlu Dibuat

| File | Endpoints | Catatan |
|------|-----------|---------|
| `services/barangApi.js` | `inv-barang` + sub-actions | `pengadaan()`, `hilang()`, `ketemu()`, `opname()`, `hapusStok()`, `riwayatMutasi()`, `riwayatPeminjaman()` |
| `services/kategoriBarangApi.js` | `inv-kategori-barang` | CRUD standar |
| `services/lokasiApi.js` | `inv-lokasi` | CRUD standar |
| `services/peminjamanApi.js` | `inv-peminjaman` + sub-actions | `kembalikan()`, `batalkan()` |
| `services/mutasiApi.js` | `inv-mutasi` | Index + Show (read-only) |

---

## 10. Mappers yang Perlu Dibuat

| File | emptyForm | mapItemToForm | buildPayload |
|------|-----------|---------------|--------------|
| `mappers/barangMapper.js` | ✅ | ✅ | ✅ |
| `mappers/kategoriBarangMapper.js` | ✅ | ✅ | ✅ |
| `mappers/lokasiMapper.js` | ✅ | ✅ | ✅ |
| `mappers/peminjamanMapper.js` | ✅ | ✅ | ✅ (termasuk details array) |
| `mappers/mutasiMapper.js` | — | — | — (read-only, tidak perlu) |

---

## 11. Composables yang Perlu Dibuat

| Composable | Fungsi |
|------------|--------|
| `useBarangLookup.js` | Autocomplete/search barang untuk form peminjaman |
| `useKategoriLookup.js` | Load daftar kategori untuk select (bisa reusable) |
| `useLokasiLookup.js` | Load daftar lokasi untuk select (bisa reusable) |

**Catatan:** `useKategoriLookup` dan `useLokasiLookup` bisa digabung jadi 1 composable `useReferenceLookup.js` atau dipisah sesuai kebutuhan.

---

## 12. Entry Point (app.js) — Registrasi Baru

```js
// Pages
import barangCrud from './pages/barang';
import kategoriBarangCrud from './pages/kategori-barang';
import lokasiCrud from './pages/lokasi';
import peminjamanCrud from './pages/peminjaman';
import mutasiCrud from './pages/mutasi';

// Components
import barangDetail from './components/barang-detail';
import peminjamanDetail from './components/peminjaman-detail';

// Alpine registration
Alpine.data('barangCrud', barangCrud);
Alpine.data('kategoriBarangCrud', kategoriBarangCrud);
Alpine.data('lokasiCrud', lokasiCrud);
Alpine.data('peminjamanCrud', peminjamanCrud);
Alpine.data('mutasiCrud', mutasiCrud);
Alpine.data('barangDetail', barangDetail);
Alpine.data('peminjamanDetail', peminjamanDetail);
```

---

## 13. Util yang Perlu Ditambah / Diperluas

| File | Tambahan |
|------|----------|
| `utils/format.js` | `statusPeminjamanBadge()`, `statusPeminjamanLabel()`, `jenisMutasiLabel()`, `stokBadge()` |
| `utils/validation.js` | `isPositiveInteger()`, `isDate()` |

---

## 14. Urutan Implementasi (Prioritas)

| Tahap | Entitas | Estimasi |
|-------|---------|----------|
| **1** | Kategori Barang + Lokasi (CRUD sederhana) | Paling cepat — copy-paste pola Pendidikan, beda API endpoint |
| **2** | Barang (CRUD utama + aksi stok) | Paling penting — inti inventaris |
| **3** | Peminjaman (header-detail + workflow) | Kompleksitas tinggi karena dynamic rows + aksi kembalikan/batalkan |
| **4** | Mutasi (read-only + filter) | Read-only, data dari backend |
| **5** | Detail page Barang + Peminjaman | Setelah halaman index selesai |

---

## 15. Catatan Penting

1. **Semua API endpoint sudah pakai auth:sanctum** — pastikan token dikirim via `Auth.getHeaders()` yang sudah ada di `httpClient.js`.
2. **Pola `apiFetch`** sudah handle error + unwrap response — tinggal pakai.
3. **Pagination** — backend sudah support pagination. Pakai `normalizePaginatedResponse()`.
4. **Barang lookup** — untuk form peminjaman, perlu composable `useBarangLookup.js` untuk autocomplete/search barang.
5. **Dynamic rows** — form peminjaman perlu row dinamis (tambah/hapus baris barang). Ini membutuhkan logika Alpine yang lebih kompleks di `peminjaman.js`.
6. **Aksi "Kembalikan"** — perlu form detail pengembalian per barang: jumlah_kembali, jumlah_hilang. Simpan via `POST /inv-peminjaman/{id}/kembalikan`.