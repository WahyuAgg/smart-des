<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\SuratController;
use App\Http\Controllers\Web\ArtikelController;
use App\Http\Controllers\Web\AdminController;


Route::get('/', function () {
    return view('welcome');
});


// Route::get('/', function () {
//     return redirect('/dashboard');
// });

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
});

Route::prefix('surat/create')->group(function () {
    Route::get('/get-templates', [SuratController::class, 'getTemplates']);
    Route::get('/get-nik-placeholders/{template_id}', [SuratController::class,'']);
    Route::post('/get-surat-placeholders', [SuratController::class, 'create']);
    Route::post('/data-surat', [SuratController::class, 'show']);
});

Route::prefix('artikel')->group(function () {

    Route::get('/', [ArtikelController::class, 'index']);

    Route::get('/{id}', [ArtikelController::class, 'show']);

});

Route::prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'index']);

});