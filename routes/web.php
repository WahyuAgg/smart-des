<?php

use Illuminate\Support\Facades\Route;

// ================================================================
// 🟢 PUBLIC — Tanpa login (warga/pengunjung)
// ================================================================
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/about', fn() => view('about.index'))->name('about');
Route::get('/peta-desa', fn() => view('peta-desa.index'))->name('peta-desa');
Route::get('/galeri', fn() => view('galeri.index'))->name('galeri');

Route::prefix('bacaan')->name('bacaan.')->group(function () {
    Route::get('/', fn() => view('bacaan.index'))->name('index');
    Route::get('/{id}', fn($id) => view('bacaan.show', ['id' => $id]))->name('show');
});

Route::prefix('surat')->name('surat.')->group(function () {
    Route::get('/', fn() => view('surat.index'))->name('index');
    Route::get('/riwayat', fn() => view('surat.riwayat.index'))->name('riwayat');
});

// ================================================================
// 🔵 LOGIN REQUIRED — Semua role (admin, petugas, kepala_desa)
// ================================================================
Route::get('/', fn() => view('dashboard.index'))->name('dashboard');



// ================================================================
// 🟡 STAFF — admin & petugas (pengelola data desa)
// ================================================================
Route::prefix('master-data')->name('master-data.')->group(function () {
    Route::get('/master-field-surat', fn() => view('master-data.master-field-surat.index'))->name('master-field-surat.index');
    Route::get('/kk', fn() => view('master-data.kk.index'))->name('kk.index');
    Route::get('/pendidikan', fn() => view('master-data.pendidikan.index'))->name('pendidikan.index');
    Route::get('/jabatan-perangkat', fn() => view('master-data.jabatan-perangkat.index'))->name('jabatan-perangkat.index');
    Route::get('/perangkat-desa', fn() => view('master-data.perangkat-desa.index'))->name('perangkat-desa.index');
    Route::get('/penduduk', fn() => view('master-data.penduduk.index'))->name('penduduk.index');
    Route::get('/kategori-surat', fn() => view('master-data.kategori-surat.index'))->name('kategori-surat.index');
    Route::get('/jenis-surat', fn() => view('master-data.jenis-surat.index'))->name('jenis-surat.index');
    Route::get('/dusun', fn() => view('master-data.dusun.index'))->name('dusun.index');
    Route::get('/rw', fn() => view('master-data.rw.index'))->name('rw.index');
    Route::get('/rt', fn() => view('master-data.rt.index'))->name('rt.index');
    Route::get('/profil-desa', fn() => view('master-data.profil-desa.index'))->name('profil-desa.index');
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

// ================================================================
// 🔴 ADMIN ONLY — Manajemen sistem
// ================================================================
Route::prefix('admin-sistem')->name('admin-sistem.')->group(function () {
    Route::get('/user', fn() => view('admin-sistem.user.index'))->name('user.index');
    Route::get('/backup', fn() => view('admin-sistem.backup.index'))->name('backup.index');
});
