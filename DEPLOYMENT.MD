# Panduan Deployment Khusus Desa Curug

Dokumen ini menjelaskan langkah-langkah deployment aplikasi untuk Desa Curug menggunakan Laravel.

---

## 1. Clone Repository

```bash
git clone <repository-url>
cd <nama-project>
```

---

## 2. Install Dependency

### Install Composer Dependency

```bash
composer install
```

### Install Node.js Dependency (Opsional)

Jalankan jika melakukan build asset menggunakan Vite.

```bash
npm install
npm run build
```

---

## 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

### Linux

```bash
cp .env.example .env
```

### Windows

```cmd
copy .env.example .env
```

Sesuaikan konfigurasi database dan pengaturan lainnya pada file `.env`.

---

## 4. Generate Application Key

```bash
php artisan key:generate
```

---

## 5. Membuat Database SQLite

### Windows

```cmd
type nul > database\database.sqlite
```

### Linux

```bash
touch database/database.sqlite
```

Pastikan konfigurasi `.env` menggunakan SQLite.

```env
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/project/database/database.sqlite
```

---

## 6. Migrasi Database

```bash
php artisan migrate
```

---

## 7. Seed Data Wilayah Indonesia

```bash
php artisan laravolt:indonesia:seed
```

---

## 8. Seed Data Awal Aplikasi

```bash
php artisan db:seed
```

---

## 9. Import Data Desa Curug

### Import Data Kartu Keluarga

```bash
php artisan import:kk storage/app/private/imports/data_kk.xlsx
```

### Import Data Penduduk Batch 1

```bash
php artisan import:penduduk storage/app/private/imports/data_penduduk_21.xlsx
```

### Import Data Penduduk Batch 2

```bash
php artisan import:penduduk storage/app/private/imports/data_penduduk_25.xlsx
```

> **Catatan:** Gunakan `/` pada path agar kompatibel di Windows maupun Linux.

---

## 10. Membuat Symbolic Link Storage

```bash
php artisan storage:link
```

---

## 11. Optimasi Aplikasi (Production)

```bash
php artisan optimize
```

Apabila terdapat perubahan konfigurasi atau cache, jalankan:

```bash
php artisan optimize:clear
php artisan optimize
```

---

## 12. Menjalankan Aplikasi

### Development

```bash
php artisan serve
```

### Production

Konfigurasikan web server (Apache/Nginx) agar document root mengarah ke folder:

```
public/
```

---

# Ringkasan Deployment

## Linux

```bash
composer install

cp .env.example .env

php artisan key:generate

touch database/database.sqlite

php artisan migrate
php artisan laravolt:indonesia:seed
php artisan db:seed

php artisan import:kk storage/app/private/imports/data_kk.xlsx
php artisan import:penduduk storage/app/private/imports/data_penduduk_21.xlsx
php artisan import:penduduk storage/app/private/imports/data_penduduk_25.xlsx

php artisan storage:link

php artisan optimize
```

## Windows

```cmd
composer install

copy .env.example .env

php artisan key:generate

type nul > database\database.sqlite

php artisan migrate
php artisan laravolt:indonesia:seed
php artisan db:seed

php artisan import:kk storage/app/private/imports/data_kk.xlsx
php artisan import:penduduk storage/app/private/imports/data_penduduk_21.xlsx
php artisan import:penduduk storage/app/private/imports/data_penduduk_25.xlsx

php artisan storage:link

php artisan optimize
```

### Testing 

php artisan db:seed --class="Database\Seeders\TestingSrtSeeder\RefPerangkatDesaSeeder"