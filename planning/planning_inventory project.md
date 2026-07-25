# Rencana Implementasi Sistem Manajemen Inventaris & Peminjaman Barang

Dokumen ini berisi rencana pengembangan sistem inventaris secara komprehensif, terstruktur, dan siap pakai berdasarkan spesifikasi arsitektur data dan aturan bisnis yang telah disepakati.

---

## 1. Arsitektur Database (Skema Relasional)

Berikut adalah struktur tabel lengkap beserta tipe data dan relasinya.

### A. Tabel Master Data

#### `inv_kategori_barang` (Kategori Barang)

| Kolom | Tipe Data | Keterangan |
| --- | --- | --- |
| `id` | INT / BIGINT | Primary Key, Auto Increment |
| `nama` | VARCHAR(100) | Nama kategori barang |
| `keterangan` | TEXT | Deskripsi opsional |

#### `inv_lokasi` (Lokasi Utama Penyimpanan)

| Kolom | Tipe Data | Keterangan |
| --- | --- | --- |
| `id` | INT / BIGINT | Primary Key, Auto Increment |
| `nama` | VARCHAR(100) | Nama lokasi/ruangan |
| `keterangan` | TEXT | Deskripsi opsional |

#### `inv_barang` (Master Data Barang & Agregat Stok)

| Kolom | Tipe Data | Keterangan |
| --- | --- | --- |
| `id` | INT / BIGINT | Primary Key, Auto Increment |
| `kode_barang` | VARCHAR(50) | Kode unik barang |
| `nama_barang` | VARCHAR(150) | Nama barang |
| `kategori_id` | INT | Foreign Key ke `inv_kategori_barang` |
| `lokasi_id` | INT | Foreign Key ke `inv_lokasi` |
| `satuan` | VARCHAR(50) | Satuan (pcs, unit, box, dll) |
| `tanggal_perolehan` | DATE | Tanggal perolehan awal |
| `keterangan` | TEXT | Catatan tambahan |
| `jumlah_total` | INT | Total fisik keseluruhan (`tersedia + rusak + dipinjam`) |
| `jumlah_tersedia` | INT | Stok yang siap dipinjam/digunakan |
| `jumlah_rusak` | INT | Stok dalam kondisi rusak |
| `jumlah_dipinjam` | INT | Stok yang sedang dalam status dipinjam |
| `created_at` | TIMESTAMP | Waktu pembuatan data |
| `updated_at` | TIMESTAMP | Waktu perubahan terakhir |

---

### B. Tabel Transaksi Peminjaman

#### `inv_peminjaman` (Header Transaksi Peminjaman)

| Kolom | Tipe Data | Keterangan |
| --- | --- | --- |
| `id` | INT / BIGINT | Primary Key, Auto Increment |
| `nomor` | VARCHAR(50) | Nomor referensi/surat peminjaman |
| `nama_peminjam` | VARCHAR(150) | Nama peminjam / penanggung jawab |
| `tanggal_pinjam` | DATE | Tanggal transaksi pinjam |
| `tanggal_rencana_kembali` | DATE | Estimasi tanggal pengembalian |
| `tanggal_kembali` | DATE | Tanggal aktual pengembalian (nullable) |
| `status` | ENUM | `dipinjam`, `dikembalikan`, `dibatalkan` |
| `keterangan` | TEXT | Catatan peminjaman |

#### `inv_detail_peminjaman` (Detail Barang yang Dipinjam & Dikembalikan)

| Kolom | Tipe Data | Keterangan |
| --- | --- | --- |
| `id` | INT / BIGINT | Primary Key, Auto Increment |
| `peminjaman_id` | INT | Foreign Key ke `inv_peminjaman` |
| `barang_id` | INT | Foreign Key ke `inv_barang` |
| `jumlah_pinjam` | INT | Jumlah barang yang dipinjam |
| `jumlah_kembali_baik` | INT | Jumlah kembali dengan kondisi baik |
| `jumlah_kembali_rusak` | INT | Jumlah kembali dengan kondisi rusak |
| `jumlah_hilang` | INT | Jumlah barang yang dilaporkan hilang |
| `keterangan` | TEXT | Catatan per item |

---

### C. Tabel Buku Besar Mutasi (Stock Ledger)

#### `inv_mutasi` (Header Mutasi Stok)

| Kolom | Tipe Data | Keterangan |
| --- | --- | --- |
| `id` | INT / BIGINT | Primary Key, Auto Increment |
| `peminjaman_id` | INT | Foreign Key ke `inv_peminjaman` (**Nullable**, terisi jika dari transaksi pinjam/kembali) |
| `nomor` | VARCHAR(50) | Nomor dokumen mutasi |
| `jenis` | ENUM | `PENGADAAN`, `PINJAM`, `KEMBALI`, `HILANG`, `RUSAK`, `OPNAME`, `HAPUS` |
| `tanggal` | DATE | Tanggal mutasi dicatat |
| `keterangan` | TEXT | Catatan mutasi |

#### `inv_detail_mutasi` (Detail Perubahan Stok per Barang)

| Kolom | Tipe Data | Keterangan |
| --- | --- | --- |
| `id` | INT / BIGINT | Primary Key, Auto Increment |
| `mutasi_id` | INT | Foreign Key ke `inv_mutasi` |
| `barang_id` | INT | Foreign Key ke `inv_barang` |
| `jumlah` | INT | Jumlah perubahan kuantitas |

---

## 2. Alur Bisnis & Aturan Validasi (Business Logic)

Sistem dibagi menjadi dua kelompok operasi utama dengan aturan mutasi dan pergerakan stok sebagai berikut:

### Kelompok 1: Edit Master (Non-Mutasi)

* **Lingkup:** Mengubah metadata barang seperti nama, kode, kategori, lokasi utama, satuan, dan keterangan.
* **Efek Stok:** **Tidak ada** perubahan kuantitas stok dan **tidak menghasilkan** data mutasi (`inv_mutasi`).

### Kelompok 2: Transaksi Mutasi Stok

Setiap aksi di bawah ini wajib menggunakan **Database Transaction (ACID)** untuk memastikan konsistensi antara tabel mutasi dan tabel agregat stok (`inv_barang`).

1. **Pengadaan (`PENGADAAN`)**
* **Efek:** `jumlah_total` dan `jumlah_tersedia` **bertambah**.
* **Rule:** -


2. **Peminjaman (`PINJAM`)**
* **Efek:** `jumlah_tersedia` **berkurang**, `jumlah_dipinjam` **bertambah**.
* **Rule:** `jumlah <= jumlah_tersedia`
* **Otomasi:** Generate record `inv_mutasi` dengan jenis `PINJAM`.


3. **Pengembalian (`KEMBALI`)**
* **Efek:** `jumlah_dipinjam` **berkurang**. Barang kembali masuk ke `jumlah_tersedia` (jika baik) atau `jumlah_rusak` (jika rusak) atau keluar sistem (jika hilang).
* **Rule:** `jumlah_kembali (baik + rusak + hilang) <= jumlah_pinjam`
* **Otomasi:**
* Generate record `inv_mutasi` dengan jenis `KEMBALI`.
* Validasi status peminjaman otomatis:
* Jika `baik + rusak + hilang == jumlah_pinjam` $\rightarrow$ Status header peminjaman menjadi `dikembalikan`.
* Jika `baik + rusak + hilang < jumlah_pinjam` $\rightarrow$ Status header peminjaman tetap `dipinjam`.






4. **Kerusakan (`RUSAK`)**
* **Efek:** `jumlah_tersedia` **berkurang**, `jumlah_rusak` **bertambah**. (`jumlah_total` tetap).
* **Rule:** `jumlah <= jumlah_tersedia`


5. **Kehilangan (`HILANG`)**
* **Efek:** `jumlah_tersedia` dan `jumlah_total` **berkurang**.
* **Rule:** `jumlah <= jumlah_tersedia`


6. **Stock Opname (`OPNAME`)**
* **Efek:** Penyesuaian fisik stok aktual (bisa bertambah atau berkurang menyesuaikan hasil opname).
* **Rule:** Disesuaikan dengan hasil penghitungan fisik riil.


7. **Penghapusan (`HAPUS`)**
* **Efek:** `jumlah_total` dan salah satu sub-status stok (tersedia/rusak) **berkurang**.
* **Rule:** `jumlah <= jumlah_tersedia` (atau sesuai stok rusak yang dihapus).



---

## 3. Batasan Cakupan Sistem (Scope Constraints)

* ❌ Tidak ada fitur pemindahan barang antar lokasi (hanya ada edit lokasi master).
* ❌ Tidak ada dukungan multi-gudang.
* ❌ Tidak ada transfer lokasi antar unit.
* ❌ Tidak ada pelacakan nomor seri (*serial number*).
* ❌ Tidak ada manajemen batch produksi.
* ❌ Tidak melibatkan data supplier.
* ❌ Tidak ada modul *purchasing* (pembelian/PO), pengadaan murni berbasis input penambahan stok manual.

---

## 4. Langkah Kunci Pengembangan Selanjutnya

1. **Pembuatan Migrasi Database:** Eksekusi skema SQL berdasarkan rancangan tabel di atas menggunakan DBMS pilihan (MySQL/PostgreSQL).
2. **Implementasi Service Layer (Backend):** Buat fungsi pembantu transaksi (*DB Transaction wrapper*) untuk menangani sinkronisasi otomatis antara tabel `inv_barang` dan `inv_mutasi`.
3. **Pengembangan Antarmuka (Frontend/UI):**
* Form Master Barang & Lokasi/Kategori.
* Form Input Transaksi Peminjaman & Pengembalian (dengan kalkulasi otomatis status).
* Laporan Buku Besar Mutasi Stok (*Stock Ledger Report*).