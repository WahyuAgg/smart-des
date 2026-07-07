<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\SuratController;
use App\Http\Controllers\Web\ArtikelController;
use App\Http\Controllers\Web\AdminController;


Route::get('/', function () {
    // return view('welcome');
});





Route::get('/', fn () => redirect()->route('surat.index'))->name('dashboard');

Route::prefix('surat')->name('surat.')->group(function () {
    Route::get('/', fn () => view('surat.index'))->name('index');
});

