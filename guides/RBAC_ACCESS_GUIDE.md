# 🛡️ RBAC — Role-Based Access Control Guide

> **Dokumentasi ini menjelaskan bagaimana sistem RBAC bekerja dan file apa saja yang perlu diubah jika ingin mengubah akses suatu role.**

---

## 📐 Arsitektur Dua Layer

Sistem RBAC berjalan di **2 layer**:

```
┌─────────────────────────────────────────────────┐
│  LAYER 1: BACKEND (Laravel + Spatie Permission) │
│  ─ Melindungi API routes                         │
│  ─ Middleware: role, permission                  │
│  ─ Database: roles, permissions, model_has_roles │
└───────────────────────┬─────────────────────────┘
                        │
┌───────────────────────▼─────────────────────────┐
│  LAYER 2: FRONTEND (Vanilla JS SPA)             │
│  ─ Client-side route guard                       │
│  ─ Sidebar menu filtering                        │
│  ─ Single Source of Truth: access.js             │
└─────────────────────────────────────────────────┘
```

---

## 📁 Daftar Lengkap File RBAC

### 🔧 Backend Files

| # | File | Fungsi |
|---|------|--------|
| 1 | `app/Models/User.php` | Model User menggunakan trait `HasRoles` dari Spatie |
| 2 | `config/permission.php` | Konfigurasi package Spatie Permission (tabel, model) |
| 3 | `bootstrap/app.php` | Register middleware alias: `role`, `permission`, `role_or_permission` |
| 4 | `routes/api.php` | Middleware `auth:sanctum` + `role:...` di setiap grup route |
| 5 | `app/Http/Controllers/Api/AuthController.php` | Return `roles` & `permissions` di response login & `/me` |
| 6 | `app/Http/Controllers/Api/RoleController.php` | Endpoint daftar semua role (untuk dropdown) |
| 7 | `database/seeders/GeneralSeeder/RoleSeeder.php` | Seeder untuk membuat role di database |
| 8 | `database/seeders/GeneralSeeder/AssignRoles.php` | Seeder untuk assign role ke user default |

### 🎨 Frontend Files

| # | File | Fungsi |
|---|------|--------|
| 9 | **`resources/js/config/access.js`** | ⭐ **Single Source of Truth** — definisi role, level, route access, sidebar menu |
| 10 | `resources/js/services/auth.js` | Helper: `requireAuth()`, `requireStaff()`, `requireAdmin()` |
| 11 | `resources/views/layouts/app.blade.php` | Route guard — baca `Access.canAccess()` |
| 12 | `resources/views/partials/sidebar.blade.php` | Filter menu sidebar berdasarkan level |
| 13 | `resources/views/partials/navbar.blade.php` | Badge role di navbar |
| 14 | `resources/js/app.js` | Expose `window.Access` ke global |

---

## 🧠 Cara Kerja

### Backend — API Protection

Semua route API CRUD dilindungi oleh middleware:

```php
// routes/api.php
Route::middleware([
    'auth:sanctum',
    'role:admin|petugas|kepala_desa',  // <— semua role bisa akses
])->group(function () {
    // Semua CRUD ada di sini
});
```

Saat ini **semua role (admin, petugas, kepala_desa) bisa mengakses semua endpoint API**. Tidak ada pembedaan per-modul di backend.

### Frontend — Client-Side Guard

Frontend membedakan akses berdasarkan **4 level**:

| Level | Role yang termasuk | Contoh Halaman |
|-------|-------------------|----------------|
| `public` | Tanpa login | Login, Peta Desa, Galeri, Bacaan |
| `auth` | admin, petugas, kepala_desa | Dashboard, Surat |
| `staff` | admin, petugas | Master Data, Inventaris, Manajemen Konten |
| `admin` | admin | Admin Sistem (User) |

---

## ✏️ Cara Mengubah Akses Role

### 🔴 Skenario 1: Ubah level akses halaman tertentu

**Contoh:** Pindahkan halaman Surat dari `auth` (semua role) ke `staff` (hanya admin & petugas).

**Edit file:** `resources/js/config/access.js`

```diff
// Di ROUTE_ACCESS
- { prefix: '/surat',          level: 'auth' },
+ { prefix: '/surat',          level: 'staff' },
```

```diff
// Di SIDEBAR_MENU
- { label: 'Pengajuan Surat', route: 'surat.index', icon: 'document', level: 'auth' },
+ { label: 'Pengajuan Surat', route: 'surat.index', icon: 'document', level: 'staff' },
```

> ✅ **Selesai!** Cukup edit `access.js`, build ulang frontend (`npm run build`).

---

### 🟡 Skenario 2: Tambah role baru

**Contoh:** Tambah role `bendahara`.

#### 1. Buat role di database

**Edit file:** `database/seeders/GeneralSeeder/RoleSeeder.php`

```php
Role::firstOrCreate(['name' => 'bendahara']);
```

Jalankan: `php artisan db:seed --class=Database\\Seeders\\GeneralSeeder\\RoleSeeder`

#### 2. Daftarkan role di frontend

**Edit file:** `resources/js/config/access.js`

```js
export const ROLES = {
  admin:       'Admin',
  petugas:     'Petugas',
  kepala_desa: 'Kepala Desa',
  bendahara:   'Bendahara',  // <— tambah
};
```

#### 3. Tentukan level akses role baru

```diff
// Di ACCESS_LEVELS
  staff: {
    label: 'Staff',
-   roles: ['admin', 'petugas'],
+   roles: ['admin', 'petugas', 'bendahara'],
  },
```

#### 4. (Opsional) Tambahkan route guard di backend

**Edit file:** `routes/api.php`

```php
Route::middleware(['auth:sanctum', 'role:admin|petugas|bendahara'])->group(function () {
    // ...
});
```

#### 5. (Opsional) Buat user default untuk role baru

**Edit file:** `database/seeders/GeneralSeeder/AssignRoles.php`

```php
$bendahara = User::updateOrCreate(
    ['email' => 'bendahara@desa.id'],
    [
        'name' => 'Bendahara',
        'password' => Hash::make('bendahara123'),
    ]
);
$bendahara->syncRoles('bendahara');
```

---

### 🟡 Skenario 3: Batasi akses API per-modul di backend

**Contoh:** Hanya admin yang bisa akses endpoint Users.

**Edit file:** `routes/api.php`

```php
// Sebelum: semua dalam satu grup
Route::middleware(['auth:sanctum', 'role:admin|petugas|kepala_desa'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('penduduk', PendudukController::class);
    // ...
});

// Sesudah: dipisah per grup
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('users', UserController::class);
});

Route::middleware(['auth:sanctum', 'role:admin|petugas'])->group(function () {
    Route::apiResource('penduduk', PendudukController::class);
    // ...
});
```

---

### 🟢 Skenario 4: Tambah method guard baru di frontend

**Contoh:** Tambah guard `requireBendahara()`.

**Edit file:** `resources/js/services/auth.js`

```js
import { isStaff, isAdmin, isKades } from '../config/access';

// Tambah fungsi baru
export function isBendahara(userRoles) {
  return userRoles?.includes('bendahara') ?? false;
}

// Di dalam object Auth
requireBendahara() {
  if (!this.requireAuth()) return false;
  const user = this.getUser();
  if (!isBendahara(user?.roles ?? [])) {
    window.location.href = '/';
    return false;
  }
  return true;
},
```

---

### 🟢 Skenario 5: Tambah permission granular (izin detail)

**Contoh:** Ingin izin spesifik seperti `penduduk.create`, `penduduk.edit`.

#### 1. Buat permission di seeder

**Edit file:** `database/seeders/GeneralSeeder/AssignRoles.php`

```php
use Spatie\Permission\Models\Permission;

// Buat permission
Permission::firstOrCreate(['name' => 'penduduk.create']);
Permission::firstOrCreate(['name' => 'penduduk.edit']);
Permission::firstOrCreate(['name' => 'penduduk.delete']);

// Assign ke role
$admin = User::where('email', 'admin@desa.id')->first();
$admin->givePermissionTo(['penduduk.create', 'penduduk.edit', 'penduduk.delete']);

$petugas = User::where('email', 'petugas@desa.id')->first();
$petugas->givePermissionTo(['penduduk.create', 'penduduk.edit']);
```

#### 2. Gunakan middleware permission di route

**Edit file:** `routes/api.php`

```php
Route::middleware(['auth:sanctum', 'permission:penduduk.create'])->group(function () {
    Route::post('penduduk', [PendudukController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'permission:penduduk.delete'])->group(function () {
    Route::delete('penduduk/{id}', [PendudukController::class, 'destroy']);
});
```

#### 3. Cek permission di frontend

**Edit file:** `resources/js/services/auth.js`

```js
// user object dari API sudah包含 permissions array
can(userPermissions, permission) {
  return userPermissions?.includes(permission) ?? false;
}
```

---

## 📋 Ringkasan Cepat — File per Kebutuhan

| Kebutuhan | File yang Diedit |
|-----------|-----------------|
| **Ubah akses halaman/sidebar** | `resources/js/config/access.js` |
| **Tambah role baru** | `RoleSeeder.php` + `access.js` + (opsional) `routes/api.php` |
| **Bedakan akses API per role** | `routes/api.php` |
| **Tambah guard method baru** | `resources/js/services/auth.js` |
| **Tambah permission granular** | `AssignRoles.php` + `routes/api.php` + `auth.js` |
| **Ubah response login/me** | `app/Http/Controllers/Api/AuthController.php` |
| **Ubah user default seeder** | `database/seeders/GeneralSeeder/AssignRoles.php` |
| **Register middleware baru** | `bootstrap/app.php` |

---

## ⚡ Command Penting

```bash
# Build ulang frontend setelah ubah access.js
npm run build

# Jalankan seeder role
php artisan db:seed --class=Database\\Seeders\\GeneralSeeder\\RoleSeeder

# Jalankan seeder assign role
php artisan db:seed --class=Database\\Seeders\\GeneralSeeder\\AssignRoles

# Reset & seed ulang database
php artisan migrate:fresh --seed
```

---

> **Prinsip utama:** Semua aturan akses frontend ada di `resources/js/config/access.js`. Ubah file itu saja untuk sebagian besar kebutuhan. Backend route guard di `routes/api.php` hanya perlu diubah jika ingin membedakan akses API secara teknis.



Revisist kalo ada bug public access need login

async init() {
    if (!Auth.requireAuth()) return;  // <— INI! redirect ke /login kalau belum login
    await this.loadPeta();
},