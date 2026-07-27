<?php

use Illuminate\Support\Facades\Route;


// ---------------------------------------------------------------
// Auth Routes
// ---------------------------------------------------------------
Route::get('/login', fn() => view('auth.login'))->name('login');


// ---------------------------------------------------------------
// Dashboard & Protected Pages
// ---------------------------------------------------------------
Route::get('/', fn() => redirect()->route('surat.index'))->name('dashboard');



// Surat Wizard Routes
Route::prefix('surat')->name('surat.')->group(function () {
    Route::get('/', fn() => view('surat.index'))->name('index');
});

// Master Data Routes
Route::prefix('master-data')->name('master-data.')->group(function () {
    Route::get('/master-field-surat', fn() => view('master-data.master-field-surat.index'))->name('master-field-surat.index');
    Route::get('/kk', fn() => view('master-data.kk.index'))->name('kk.index');
    Route::get('/pendidikan', fn() => view('master-data.pendidikan.index'))->name('pendidikan.index');
    Route::get('/jabatan-perangkat', fn() => view('master-data.jabatan-perangkat.index'))->name('jabatan-perangkat.index');
    Route::get('/perangkat-desa', fn() => view('master-data.perangkat-desa.index'))->name('perangkat-desa.index');
    Route::get('/penduduk', fn() => view('master-data.penduduk.index'))->name('penduduk.index');
    // more master data routes can be added here
});

// Inventaris Routes
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
