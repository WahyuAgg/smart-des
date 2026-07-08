<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\SuratController;
use App\Http\Controllers\Web\ArtikelController;
use App\Http\Controllers\Web\AdminController;


// ---------------------------------------------------------------
// Auth Routes
// ---------------------------------------------------------------
Route::get('/login', fn () => view('auth.login'))->name('login');


// ---------------------------------------------------------------
// Dashboard & Protected Pages
// ---------------------------------------------------------------
Route::get('/', fn () => redirect()->route('surat.index'))->name('dashboard');

Route::prefix('surat')->name('surat.')->group(function () {
    Route::get('/', fn () => view('surat.index'))->name('index');
});

Route::prefix('master-data')->name('master-data.')->group(function () {
    Route::get('/master-field-surat', fn () => view('master-data.master-field-surat.index'))->name('master-field-surat.index');
});
