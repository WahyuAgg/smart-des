<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\SuratController;
use App\Http\Controllers\Web\ArtikelController;
use App\Http\Controllers\Web\AdminController;


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
    // more master data routes can be added here
});

Route::get('/master-data/penduduk', function () {
    return view('master-data.penduduk.index');
})->name('master-data.penduduk.index');
