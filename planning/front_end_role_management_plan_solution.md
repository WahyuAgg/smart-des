# Front-End Role Management Plan & Solution

> **Project**: SmartDes (KKN Web Desa)  
> **Date**: 2026-07-30  
> **Status**: Implementation Phase  
> **Audience**: Developers, AI/ML agents, Future maintainers

---

## 📋 Executive Summary

This document defines a **comprehensive, layered Role-Based Access Control (RBAC)** strategy for the SmartDes frontend. The solution combines **server-side enforcement** (Laravel middleware + policies) with **client-side UX optimization** (Alpine.js guards + centralized config) to achieve security, maintainability, and developer experience.

**Core Principle**: *Defense in Depth* — Multiple layers, each independently effective, together bulletproof.

---

## 🎯 Objectives

| Objective | Success Criteria |
|-----------|------------------|
| **Security** | Unauthorized users cannot access protected pages/data (server-enforced) |
| **Maintainability** | Single source of truth for roles/permissions/routes/menu |
| **Developer Experience** | Add new role/page → edit 1 file, zero duplication |
| **User Experience** | Instant redirects, reactive UI, no flash of unauthorized content |
| **Scalability** | Support new roles, granular permissions, multi-desa future |

---

## 🏗️ Architecture Overview

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                        LAYERED RBAC ARCHITECTURE                            │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  ┌──────────────────┐    ┌──────────────────┐    ┌──────────────────┐     │
│  │   LAYER 1        │    │   LAYER 2        │    │   LAYER 3        │     │
│  │   ROUTE          │    │   CENTRALIZED    │    │   CLIENT GUARD   │     │
│  │   MIDDLEWARE     │    │   CONFIG         │    │   (ALPINE.JS)    │     │
│  │   (SERVER)       │    │   (JS/TS)        │    │   (BROWSER)      │     │
│  ├──────────────────┤    ├──────────────────┤    ├──────────────────┤     │
│  │ • auth           │    │ • ROLES          │    │ • Route guard    │     │
│  │ • role:admin     │    │ • ACCESS_LEVELS  │    │ • Reactive UI    │     │
│  │ • role:staff     │    │ • ROUTE_ACCESS   │    │ • Sidebar filter │     │
│  │ • Redirect HTML  │    │ • SIDEBAR_MENU   │    │ • Navbar badges  │     │
│  └────────┬─────────┘    └────────┬─────────┘    └────────┬─────────┘     │
│           │                       │                       │               │
│           ▼                       ▼                       ▼               │
│  ┌──────────────────────────────────────────────────────────────────┐    │
│  │                    LAYER 4: POLICIES (SERVER)                    │    │
│  │  • Ownership checks (user owns record)                           │    │
│  │  • Business logic (status, workflow, multi-desa)                 │    │
│  │  • $this->authorize() in Controllers                             │    │
│  └──────────────────────────────────────────────────────────────────┘    │
│           │                                                               │
│           ▼                                                               │
│  ┌──────────────────────────────────────────────────────────────────┐    │
│  │                    LAYER 5: BLADE DIRECTIVES                     │    │
│  │  • @role('admin|petugas') — UI conditional                       │    │
│  │  • @can('delete', $model) — Policy-based UI                      │    │
│  └──────────────────────────────────────────────────────────────────┘    │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 📁 File Structure & Responsibilities

```
SmartDes/
├── app/
│   ├── Http/
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php          # Custom: HTML redirect for web
│   │   └── Kernel.php                      # Middleware aliases
│   ├── Policies/                           # Layer 4
│   │   ├── PendudukPolicy.php
│   │   ├── KkPolicy.php
│   │   ├── SuratPolicy.php
│   │   └── ...
│   └── Providers/
│       └── AuthServiceProvider.php         # Policy registration
│
├── bootstrap/
│   └── app.php                             # Middleware registration
│
├── config/
│   ├── permission.php                      # Spatie config
│   └── sidebar.php                         # (Optional) PHP mirror of JS config
│
├── resources/
│   ├── js/
│   │   ├── config/
│   │   │   └── access.js                   # 🎯 SINGLE SOURCE OF TRUTH
│   │   ├── services/
│   │   │   └── auth.js                     # Auth helper + guards
│   │   └── app.js                          # Expose window.Access
│   │
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               # Client guard IIFE
│       ├── partials/
│       │   ├── sidebar.blade.php           # Uses Access.canAccess()
│       │   └── navbar.blade.php            # Uses Access.isAdmin()
│       └── ...
│
├── routes/
│   ├── web.php                             # Layer 1: Middleware groups
│   └── api.php                             # Layer 1: Sanctum + role middleware
│
└── planning/
    └── front_end_role_management_plan_solution.md  # This file
```

---

## 🔐 Layer 1: Route Middleware (Server-Side Enforcement)

### 1.1 Web Routes (`routes/web.php`)

```php
<?php
use Illuminate\Support\Facades\Route;

// ============================================================
// 🟢 PUBLIC — No authentication required
// ============================================================
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/about', fn() => view('about.index'))->name('about');
Route::get('/peta-desa', fn() => view('peta-desa.index'))->name('peta-desa');
Route::get('/galeri', fn() => view('galeri.index'))->name('galeri');
Route::prefix('bacaan')->name('bacaan.')->group(function () {
    Route::get('/', fn() => view('bacaan.index'))->name('index');
    Route::get('/{id}', fn($id) => view('bacaan.show', ['id' => $id]))->name('show');
});

// ============================================================
// 🔵 AUTHENTICATED — All logged-in roles
// ============================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/', fn() => view('dashboard.index'))->name('dashboard');
    
    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/', fn() => view('surat.index'))->name('index');
        Route::get('/riwayat', fn() => view('surat.riwayat.index'))->name('riwayat');
    });

    // ========================================================
    // 🟡 STAFF — Admin & Petugas (Data Management)
    // ========================================================
    Route::middleware('role:admin|petugas')->group(function () {
        Route::prefix('master-data')->name('master-data.')->group(function () {
            Route::get('/profil-desa', fn() => view('master-data.profil-desa.index'))->name('profil-desa.index');
            Route::get('/dusun', fn() => view('master-data.dusun.index'))->name('dusun.index');
            Route::get('/rw', fn() => view('master-data.rw.index'))->name('rw.index');
            Route::get('/rt', fn() => view('master-data.rt.index'))->name('rt.index');
            Route::get('/kk', fn() => view('master-data.kk.index'))->name('kk.index');
            Route::get('/pendidikan', fn() => view('master-data.pendidikan.index'))->name('pendidikan.index');
            Route::get('/jabatan-perangkat', fn() => view('master-data.jabatan-perangkat.index'))->name('jabatan-perangkat.index');
            Route::get('/perangkat-desa', fn() => view('master-data.perangkat-desa.index'))->name('perangkat-desa.index');
            Route::get('/penduduk', fn() => view('master-data.penduduk.index'))->name('penduduk.index');
            Route::get('/kategori-surat', fn() => view('master-data.kategori-surat.index'))->name('kategori-surat.index');
            Route::get('/jenis-surat', fn() => view('master-data.jenis-surat.index'))->name('jenis-surat.index');
            Route::get('/master-field-surat', fn() => view('master-data.master-field-surat.index'))->name('master-field-surat.index');
        });

        Route::prefix('inventaris')->name('inventaris.')->group(function () {
            Route::get('/kategori-barang', fn() => view('inventaris.kategori-barang.index'))->name('kategori-barang.index');
            Route::get('/lokasi', fn() => view('inventaris.lokasi.index'))->name('lokasi.index');
            Route::get('/barang', fn() => view('inventaris.barang.index'))->name('barang.index');
            Route::get('/barang/{id}', fn($id) => view('inventaris.barang.detail', ['id' => $id]))->name('barang.detail');
            Route::get('/peminjaman', fn() => view('inventaris.peminjaman.index'))->name('peminjaman.index');
            Route::get('/peminjaman/{id}', fn($id) => view('inventaris.peminjaman.detail', ['id' => $id]))->name('peminjaman.detail');
            Route::get('/mutasi', fn() => view('inventaris.mutasi.index'))->name('mutasi.index');
            Route::get('/mutasi/{id}', fn($id) => view('inventaris.mutasi.show', ['id' => $id]))->name('mutasi.show');
        });

        Route::prefix('manajemen-konten')->name('manajemen-konten.')->group(function () {
            Route::get('/artikel', fn() => view('manajemen-konten.artikel.index'))->name('artikel.index');
            Route::get('/galeri', fn() => view('manajemen-konten.galeri.index'))->name('galeri.index');
        });
    });

    // ========================================================
    // 🔴 ADMIN ONLY — System Administration
    // ========================================================
    Route::middleware('role:admin')->prefix('admin-sistem')->name('admin-sistem.')->group(function () {
        Route::get('/user', fn() => view('admin-sistem.user.index'))->name('user.index');
    });
});
```

### 1.2 Custom Role Middleware (`app/Http/Middleware/RoleMiddleware.php`)

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\RoleMiddleware as SpatieRoleMiddleware;

class RoleMiddleware extends SpatieRoleMiddleware
{
    /**
     * Handle unauthorized access for web routes (HTML redirect)
     */
    protected function unauthorizedResponse(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Web: Redirect with flash message
        $message = 'Anda tidak memiliki akses ke halaman ini.';
        
        // If not logged in, go to login
        if (! $request->user()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Logged in but wrong role
        return redirect()->route('dashboard')
            ->with('error', $message);
    }
}
```

### 1.3 Register Middleware (`bootstrap/app.php`)

```php
->withMiddleware(function ($middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ]);
})
```

### 1.4 API Routes (`routes/api.php`) — Already Correct

```php
Route::middleware(['auth:sanctum', 'role:admin|petugas|kepala_desa'])->group(function () {
    // All CRUD API endpoints
    Route::apiResource('penduduk', PendudukController::class);
    Route::apiResource('kk', KkController::class);
    // ...
});
```

---

## 🎯 Layer 2: Centralized Config — Single Source of Truth

### File: `resources/js/config/access.js`

```javascript
/**
 * ACCESS CONTROL CONFIG — Single Source of Truth
 * 
 * ALL role/permission/route/menu definitions live here.
 * Other layers IMPORT from this file.
 * 
 * To modify access rules: EDIT THIS FILE ONLY.
 */

// ============================================================
// 1. ROLE DEFINITIONS
// ============================================================
export const ROLES = {
    admin:       'Admin',
    petugas:     'Petugas',
    kepala_desa: 'Kepala Desa',
} as const;

export type Role = keyof typeof ROLES;

// ============================================================
// 2. ACCESS LEVELS (Hierarchical)
// ============================================================
export const ACCESS_LEVELS = {
    public:  { label: 'Publik',      roles: [] as Role[] },
    auth:    { label: 'Login Required', roles: ['admin', 'petugas', 'kepala_desa'] as Role[] },
    staff:   { label: 'Staff',       roles: ['admin', 'petugas'] as Role[] },
    admin:   { label: 'Admin',       roles: ['admin'] as Role[] },
} as const;

export type AccessLevel = keyof typeof ACCESS_LEVELS;

// ============================================================
// 3. ROUTE → LEVEL MAPPING
// ============================================================
export const ROUTE_ACCESS = [
    // Public
    { prefix: '/login',          level: 'public' as AccessLevel },
    { prefix: '/about',          level: 'public' as AccessLevel },
    { prefix: '/peta-desa',      level: 'public' as AccessLevel },
    { prefix: '/galeri',         level: 'public' as AccessLevel },
    { prefix: '/bacaan',         level: 'public' as AccessLevel },

    // Auth required
    { prefix: '/',               level: 'auth' as AccessLevel },      // Dashboard
    { prefix: '/surat',          level: 'auth' as AccessLevel },

    // Staff required
    { prefix: '/master-data',    level: 'staff' as AccessLevel },
    { prefix: '/inventaris',     level: 'staff' as AccessLevel },
    { prefix: '/manajemen-konten', level: 'staff' as AccessLevel },

    // Admin required
    { prefix: '/admin-sistem',   level: 'admin' as AccessLevel },
] as const;

// ============================================================
// 4. SIDEBAR MENU DEFINITION
// ============================================================
export interface MenuItem {
    label: string;
    route: string;
    icon: string;
    level: AccessLevel;
}

export interface MenuGroup {
    group: string;
    icon: string;
    level: AccessLevel;
    children: Array<{ label: string; route: string }>;
}

export type SidebarEntry = MenuItem | MenuGroup;

export const SIDEBAR_MENU: SidebarEntry[] = [
    // Top-level items
    { label: 'Dashboard',          route: 'dashboard',              icon: 'home',     level: 'auth' },
    { label: 'Pengajuan Surat',    route: 'surat.index',            icon: 'document', level: 'auth' },
    { label: 'Peta Desa',          route: 'peta-desa',              icon: 'map',      level: 'public' },
    { label: 'Galeri Foto',        route: 'galeri',                 icon: 'camera',   level: 'public' },
    { label: 'Bacaan Edukatif',    route: 'bacaan.index',           icon: 'book',     level: 'public' },

    // Groups
    {
        group: 'Master Data Desa',
        icon: 'database',
        level: 'staff',
        children: [
            { label: 'Profil Desa',        route: 'master-data.profil-desa.index' },
            { label: 'Dusun',              route: 'master-data.dusun.index' },
            { label: 'RW',                 route: 'master-data.rw.index' },
            { label: 'RT',                 route: 'master-data.rt.index' },
            { label: 'KK / Kartu Keluarga',route: 'master-data.kk.index' },
            { label: 'Pendidikan',         route: 'master-data.pendidikan.index' },
            { label: 'Jabatan Perangkat',  route: 'master-data.jabatan-perangkat.index' },
            { label: 'Perangkat Desa',     route: 'master-data.perangkat-desa.index' },
            { label: 'Penduduk',           route: 'master-data.penduduk.index' },
        ],
    },
    {
        group: 'Master Data Surat',
        icon: 'document',
        level: 'staff',
        children: [
            { label: 'Kategori Surat',     route: 'master-data.kategori-surat.index' },
            { label: 'Jenis Surat',        route: 'master-data.jenis-surat.index' },
            { label: 'Field Surat',        route: 'master-data.master-field-surat.index' },
            { label: 'Riwayat Surat',      route: 'surat.riwayat' },
        ],
    },
    {
        group: 'Inventaris Desa',
        icon: 'box',
        level: 'staff',
        children: [
            { label: 'Kategori Barang',    route: 'inventaris.kategori-barang.index' },
            { label: 'Lokasi',             route: 'inventaris.lokasi.index' },
            { label: 'Daftar Barang',      route: 'inventaris.barang.index' },
            { label: 'Peminjaman',         route: 'inventaris.peminjaman.index' },
            { label: 'Mutasi / Buku Besar',route: 'inventaris.mutasi.index' },
        ],
    },
    {
        group: 'Manajemen Konten',
        icon: 'edit',
        level: 'staff',
        children: [
            { label: 'Artikel',            route: 'manajemen-konten.artikel.index' },
            { label: 'Galeri',             route: 'manajemen-konten.galeri.index' },
        ],
    },
    {
        group: 'Admin Sistem',
        icon: 'settings',
        level: 'admin',
        children: [
            { label: 'User',               route: 'admin-sistem.user.index' },
        ],
    },
];

// ============================================================
// 5. ICON PATHS (SVG)
// ============================================================
export const ICONS = {
    home:       'M3 11.5 12 4l9 7.5M5 10v9a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1v-9',
    document:   'M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm7 0v5h5M9 13h6M9 17h6M9 9h2',
    history:    'M4 4v5h5M4.6 12A8 8 0 1 0 6 6.3L4 9M12 8v4l3 2',
    database:   'M12 4c4.4 0 8 1.1 8 2.5S16.4 9 12 9s-8-1.1-8-2.5S7.6 4 12 4Zm-8 2.5V17c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5V6.5M4 11.75c0 1.4 3.6 2.5 8 2.5s8-1.1 8-2.5',
    box:        'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16zM3.27 6.96 12 12.01l8.73-5.05M12 22.08V12',
    map:        'M9 20 4 17V5l5 3m0 0 5-3m-5 3v12m5-9 5-3v12l-5 3m0-12-5 3',
    book:       'M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5A2.5 2.5 0 0 1 4 19.5ZM12 7v8M8 7v2m8-2v2',
    edit:       'M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5m-9 3 9-9 3 3-9 9H9v-3Z',
    camera:     'M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2v11ZM9 13a3 3 0 1 0 6 0 3 3 0 0 0-6 0Z',
    settings:   'M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm0 0h0M8.3 21l-.9-1.6a10.5 10.5 0 0 1-1.3-.5l-1.7.5-1.4-2.4 1.3-1.2a9.5 9.5 0 0 1-.2-1.8 9.5 9.5 0 0 1 .2-1.8L3.4 11l1.4-2.4 1.7.5c.4-.2.8-.4 1.3-.5L8.3 7l1.4-2.4 1.7.5c.4-.3.8-.5 1.3-.6l.7-1.5h2.8l.7 1.5c.5.1.9.3 1.3.6l1.7-.5L20.6 7l-1.3 1.2c.3.6.5 1.1.6 1.8l1.7.5-1.4 2.4-1.7-.5c-.1.6-.3 1.2-.5 1.8l1.3 1.2-1.4 2.4-1.7-.5c-.4.2-.8.4-1.3.5l-.7 1.5H12l-.7-1.5a10.5 10.5 0 0 1-1.3-.5l-1.7.5L6.9 19l1.3-1.2a9.5 9.5 0 0 1-.2-1.8Z',
} as const;

// ============================================================
// 6. HELPER FUNCTIONS
// ============================================================

/** Check if user roles grant access to a level */
export function canAccess(userRoles: Role[], level: AccessLevel): boolean {
    if (level === 'public') return true;
    if (!userRoles?.length) return false;
    const allowed = ACCESS_LEVELS[level]?.roles ?? [];
    return userRoles.some(r => allowed.includes(r));
}

/** Check if user is staff (admin or petugas) */
export function isStaff(userRoles: Role[]): boolean {
    return canAccess(userRoles, 'staff');
}

/** Check if user is admin */
export function isAdmin(userRoles: Role[]): boolean {
    return canAccess(userRoles, 'admin');
}

/** Check if user is kepala desa */
export function isKades(userRoles: Role[]): boolean {
    return userRoles?.includes('kepala_desa') ?? false;
}

/** Get required access level for a path */
export function getRouteLevel(path: string): AccessLevel {
    const sorted = [...ROUTE_ACCESS].sort((a, b) => b.prefix.length - a.prefix.length);
    for (const entry of sorted) {
        if (entry.prefix === '/') {
            if (path === '/' || path === '') return entry.level;
        } else if (path === entry.prefix || path.startsWith(entry.prefix + '/')) {
            return entry.level;
        }
    }
    return 'public';
}
```

---

## 🛡️ Layer 3: Client Guard (Alpine.js)

### 3.1 Expose Config (`resources/js/app.js`)

```javascript
import { 
    canAccess, isStaff, isAdmin, isKades, getRouteLevel,
    ROLES, ACCESS_LEVELS, ROUTE_ACCESS, SIDEBAR_MENU, ICONS 
} from './config/access';

window.Access = { 
    canAccess, isStaff, isAdmin, isKades, getRouteLevel,
    ROLES, ACCESS_LEVELS, ROUTE_ACCESS, SIDEBAR_MENU, ICONS 
};
```

### 3.2 Global Route Guard (`resources/views/layouts/app.blade.php`)

```blade
<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('user', {
        get current() { return Auth.getUser(); },
        get isLoggedIn() { return Auth.isLoggedIn(); },
        get roles() { return this.current?.roles ?? []; },
        hasRole(role) { return this.roles.includes(role); },
        get isAdmin() { return Access.isAdmin(this.roles); },
        get isPetugas() { return this.hasRole('petugas'); },
        get isKades() { return Access.isKades(this.roles); },
        get isStaff() { return Access.isStaff(this.roles); },
    });
});

// Client-side route guard — runs on EVERY page load
(function() {
    const path = window.location.pathname;
    const level = Access.getRouteLevel(path);
    const user = Auth.getUser();
    const roles = user?.roles ?? [];

    if (!Access.canAccess(roles, level)) {
        if (level === 'public') return;
        if (level === 'auth' && !user) {
            window.location.href = '/login';
        } else {
            window.location.href = user ? '/' : '/login';
        }
    }
})();
</script>
```

### 3.3 Auth Service Guards (`resources/js/services/auth.js`)

```javascript
import { isStaff, isAdmin, isKades } from '../config/access';

export const Auth = {
    // ... existing methods ...

    requireAuth() {
        if (!this.isLoggedIn()) { window.location.href = '/login'; return false; }
        return true;
    },

    requireStaff() {
        if (!this.requireAuth()) return false;
        if (!isStaff(this.getUser()?.roles ?? [])) { window.location.href = '/'; return false; }
        return true;
    },

    requireAdmin() {
        if (!this.requireAuth()) return false;
        if (!isAdmin(this.getUser()?.roles ?? [])) { window.location.href = '/'; return false; }
        return true;
    },

    requireKades() {
        if (!this.requireAuth()) return false;
        if (!isKades(this.getUser()?.roles ?? [])) { window.location.href = '/'; return false; }
        return true;
    },
};
```

---

## 🎨 Layer 4: Blade Directives (UI Conditional)

### 4.1 Sidebar (`resources/views/partials/sidebar.blade.php`)

```blade
@php
    $sidebarMenu = Access.SIDEBAR_MENU ?? [];
    $icons = Access.ICONS ?? [];
@endphp

<aside x-data x-show="$store.sidebar.open" x-cloak class="fixed inset-y-0 left-0 w-64 bg-navy-900...">
    <!-- Header -->
    <div class="h-16 flex items-center gap-2 px-5 border-b border-white/10">...</div>

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        @foreach ($sidebarMenu as $entry)
            @if (isset($entry['group']))
                {{-- GROUP --}}
                <div x-show="Access.canAccess($store.user.roles, '{{ $entry['level'] }}')" 
                     x-data="{ open: {{ request()->routeIs($entry['children'][0]['route'].'*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center gap-3 px-3 py-2.5...">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="{{ $icons[$entry['icon']] }}" />
                        </svg>
                        <span class="flex-1 text-left">{{ $entry['group'] }}</span>
                        <svg class="w-4 h-4" :class="open && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-11 mt-1 space-y-1 border-l border-white/10 pl-3">
                        @foreach ($entry['children'] as $child)
                            @php $subActive = request()->routeIs($child['route'].'*'); @endphp
                            <a href="{{ route($child['route']) }}" class="block px-2 py-1.5 rounded-md text-sm transition {{ $subActive ? 'text-accent font-medium' : 'text-slate-400 hover:text-white' }}">
                                {{ $child['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- TOP-LEVEL ITEM --}}
                @php $active = request()->routeIs($entry['route'].'*'); @endphp
                <a href="{{ route($entry['route']) }}"
                   x-show="Access.canAccess($store.user.roles, '{{ $entry['level'] }}')"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ $active ? 'bg-navy-700 text-white border-l-2 border-accent' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="{{ $icons[$entry['icon']] }}" />
                    </svg>
                    {{ $entry['label'] }}
                </a>
            @endif
        @endforeach
    </nav>

    {{-- User Footer --}}
    <div x-show="$store.user.isLoggedIn" class="px-3 py-4 border-t border-white/10 text-xs text-slate-400">
        Masuk sebagai <span class="text-slate-200 font-medium" x-text="$store.user.current?.name || 'Petugas'"></span>
        <span x-show="Access.isAdmin($store.user.roles)" class="ml-1.5 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-accent/20 text-accent">Admin</span>
        <span x-show="$store.user.hasRole('petugas')" class="ml-1.5 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-blue-400/20 text-blue-300">Petugas</span>
        <span x-show="Access.isKades($store.user.roles)" class="ml-1.5 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-green-400/20 text-green-300">Kepala Desa</span>
    </div>
</aside>
```

### 4.2 Navbar (`resources/views/partials/navbar.blade.php`)

```blade
<template x-if="$store.user.isLoggedIn">
    <div class="flex items-center gap-3">
        <span x-show="Access.isAdmin($store.user.roles)" class="hidden sm:inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-accent/10 text-accent border border-accent/20">Admin</span>
        <span x-show="$store.user.hasRole('petugas')" class="hidden sm:inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-600 border border-blue-200">Petugas</span>
        <span x-show="Access.isKades($store.user.roles)" class="hidden sm:inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-50 text-green-600 border border-green-200">Kepala Desa</span>
        <!-- Avatar + Logout -->
    </div>
</template>
```

---

## 📋 Layer 5: Policies (Server-Side Business Logic)

### 5.1 Example Policy (`app/Policies/PendudukPolicy.php`)

```php
<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Penduduk;

class PendudukPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin|petugas');
    }

    public function view(User $user, Penduduk $penduduk): bool
    {
        // Admin/petugas can view all
        if ($user->hasRole('admin|petugas')) return true;
        
        // Owner can view own record
        return $user->id === $penduduk->user_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin|petugas');
    }

    public function update(User $user, Penduduk $penduduk): bool
    {
        if ($user->hasRole('admin')) return true;
        if ($user->hasRole('petugas')) return true; // Petugas can update
        return $user->id === $penduduk->user_id; // Owner can update own
    }

    public function delete(User $user, Penduduk $penduduk): bool
    {
        return $user->hasRole('admin'); // Only admin can delete
    }

    public function import(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
```

### 5.2 Register Policies (`app/Providers/AuthServiceProvider.php`)

```php
protected $policies = [
    \App\Models\Penduduk::class => \App\Policies\PendudukPolicy::class,
    \App\Models\Kk::class => \App\Policies\KkPolicy::class,
    \App\Models\SrtPengajuanSurat::class => \App\Policies\SuratPolicy::class,
    \App\Models\InvBarang::class => \App\Policies\BarangPolicy::class,
    \App\Models\InvPeminjaman::class => \App\Policies\PeminjamanPolicy::class,
];
```

### 5.3 Usage in Controllers

```php
public function show(Penduduk $penduduk)
{
    $this->authorize('view', $penduduk); // Throws 403 if denied
    return view('master-data.penduduk.show', compact('penduduk'));
}

public function destroy(Penduduk $penduduk)
{
    $this->authorize('delete', $penduduk);
    $penduduk->delete();
    return redirect()->back()->with('success', 'Data dihapus');
}
```

### 5.4 Usage in Blade (Policy-based UI)

```blade
@can('update', $penduduk)
    <button wire:click="edit">Edit</button>
@endcan

@can('delete', $penduduk)
    <button wire:click="delete" class="text-red-500">Hapus</button>
@endcan

@cannot('import', \App\Models\Penduduk::class)
    {{-- Hide import button --}}
@endcannot
```

---

## 🔄 Implementation Checklist

### Phase 1: Foundation (Week 1)
- [x] Create `resources/js/config/access.js` (Single Source of Truth)
- [x] Expose `window.Access` in `app.js`
- [x] Client route guard in `layouts/app.blade.php`
- [x] Update `services/auth.js` to use `access.js` helpers
- [x] Update sidebar/navbar to use `Access.canAccess()`

### Phase 2: Server Enforcement (Week 1-2)
- [ ] Create `app/Http/Middleware/RoleMiddleware.php` (HTML redirect)
- [ ] Register middleware in `bootstrap/app.php`
- [ ] Update `routes/web.php` with middleware groups
- [ ] Test all routes with different roles

### Phase 3: Policies (Week 2)
- [ ] Create policies for: Penduduk, KK, Surat, Barang, Peminjaman
- [ ] Register in `AuthServiceProvider`
- [ ] Add `$this->authorize()` in controllers
- [ ] Add `@can`/`@cannot` in Blade views

### Phase 4: Polish (Week 2-3)
- [ ] Add flash messages for unauthorized redirects
- [ ] Create 403 error page
- [ ] Add loading states during auth checks
- [ ] Document role matrix in README

---

## 🧪 Testing Strategy

### Unit Tests (PHP)
```php
// tests/Feature/RoleMiddlewareTest.php
public function test_admin_can_access_master_data()
{
    $admin = User::factory()->create()->assignRole('admin');
    $response = $this->actingAs($admin)->get('/master-data/penduduk');
    $response->assertStatus(200);
}

public function test_petugas_cannot_access_admin_sistem()
{
    $petugas = User::factory()->create()->assignRole('petugas');
    $response = $this->actingAs($petugas)->get('/admin-sistem/user');
    $response->assertRedirect('/dashboard');
    $response->assertSessionHas('error');
}

public function test_guest_redirected_to_login()
{
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
}
```

### Policy Tests
```php
// tests/Unit/Policies/PendudukPolicyTest.php
public function test_owner_can_view_own_penduduk()
{
    $user = User::factory()->create();
    $penduduk = Penduduk::factory()->create(['user_id' => $user->id]);
    $this->assertTrue($user->can('view', $penduduk));
}

public function test_petugas_can_update_any_penduduk()
{
    $petugas = User::factory()->create()->assignRole('petugas');
    $penduduk = Penduduk::factory()->create();
    $this->assertTrue($petugas->can('update', $penduduk));
}
```

### Frontend Tests (Cypress/Playwright)
```javascript
// cypress/e2e/role-access.cy.js
describe('Role-based access', () => {
    it('admin sees all sidebar groups', () => {
        cy.login('admin@desa.id', 'password');
        cy.visit('/');
        cy.contains('Master Data Desa').should('be.visible');
        cy.contains('Admin Sistem').should('be.visible');
    });

    it('petugas sees staff groups but not admin', () => {
        cy.login('petugas@desa.id', 'password');
        cy.visit('/');
        cy.contains('Master Data Desa').should('be.visible');
        cy.contains('Admin Sistem').should('not.exist');
    });

    it('kepala_desa only sees public + auth pages', () => {
        cy.login('kades@desa.id', 'password');
        cy.visit('/');
        cy.contains('Master Data Desa').should('not.exist');
        cy.contains('Dashboard').should('be.visible');
    });
});
```

---

## 📊 Role × Page Access Matrix

| Page / Feature | Public | Kepala Desa | Petugas | Admin |
|----------------|:------:|:-----------:|:-------:|:-----:|
| Login | ✅ | ✅ | ✅ | ✅ |
| About | ✅ | ✅ | ✅ | ✅ |
| Peta Desa | ✅ | ✅ | ✅ | ✅ |
| Galeri Foto | ✅ | ✅ | ✅ | ✅ |
| Bacaan Edukatif | ✅ | ✅ | ✅ | ✅ |
| Dashboard | ❌ | ✅ | ✅ | ✅ |
| Pengajuan Surat | ❌ | ✅ | ✅ | ✅ |
| Riwayat Surat | ❌ | ✅ | ✅ | ✅ |
| Master Data (all) | ❌ | ❌ | ✅ | ✅ |
| Inventaris (all) | ❌ | ❌ | ✅ | ✅ |
| Manajemen Konten | ❌ | ❌ | ✅ | ✅ |
| Admin Sistem (User) | ❌ | ❌ | ❌ | ✅ |
| API CRUD (all) | ❌ | ✅* | ✅ | ✅ |

*Kepala Desa: Read-only API access via `role:kepala_desa` in API middleware

---

## 🚀 Future Extensibility

### Adding a New Role (e.g., `operator`)

1. **`access.js`** — Add to `ROLES` and `ACCESS_LEVELS.staff.roles`
2. **Database** — `php artisan permission:create-role operator`
3. **Routes** — No change (uses `staff` level)
4. **Policies** — Add `operator` checks where needed
5. **Tests** — Add test cases for new role

### Adding Granular Permissions

```javascript
// access.js — extend with permissions
export const PERMISSIONS = {
    'penduduk.view':   { roles: ['admin', 'petugas', 'kepala_desa'] },
    'penduduk.create': { roles: ['admin', 'petugas'] },
    'penduduk.edit':   { roles: ['admin', 'petugas'] },
    'penduduk.delete': { roles: ['admin'] },
    'penduduk.import': { roles: ['admin'] },
    // ...
};

// Helper
export function can(userRoles, permission) {
    const allowed = PERMISSIONS[permission]?.roles ?? [];
    return userRoles.some(r => allowed.includes(r));
}
```

### Multi-Desa Support (Future)

```javascript
// access.js — add desa context
export function canAccessInDesa(userRoles, level, userDesaId, targetDesaId) {
    if (level === 'public') return true;
    if (!userRoles?.length) return false;
    
    // Admin bypasses desa check
    if (userRoles.includes('admin')) return true;
    
    // Staff must belong to same desa
    return userDesaId === targetDesaId;
}
```

---

## 📚 References & Dependencies

| Package | Version | Purpose |
|---------|---------|---------|
| `spatie/laravel-permission` | ^6.0 | Roles & permissions |
| `laravel/sanctum` | ^4.0 | API token auth |
| `alpinejs` | ^3.13 | Reactive frontend |
| `@alpinejs/collapse` | ^3.13 | Sidebar collapse |

### Key Files to Remember

| File | Purpose |
|------|---------|
| `resources/js/config/access.js` | **Single Source of Truth** |
| `routes/web.php` | Server route middleware |
| `app/Http/Middleware/RoleMiddleware.php` | HTML redirect for web |
| `app/Policies/*.php` | Business logic authorization |
| `resources/views/layouts/app.blade.php` | Client route guard |
| `resources/views/partials/sidebar.blade.php` | Reactive menu |

---

## ✅ Definition of Done

- [ ] All web routes protected by appropriate middleware
- [ ] All API routes protected by `auth:sanctum` + `role:`
- [ ] Policies cover all CRUD operations with ownership logic
- [ ] Sidebar/navbar reactive to role changes (no reload needed)
- [ ] Client guard redirects unauthorized access instantly
- [ ] Flash messages show on server-side redirects
- [ ] Unit tests pass for middleware + policies
- [ ] E2E tests pass for all role × page combinations
- [ ] Documentation updated (this file + README)

---

**End of Plan** — This document should be updated whenever access rules change.