<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Surat Routes
 */
Route::prefix('surat')->group(function () {
    Route::get('/', [SuratController::class, 'index']);
    Route::get('/{id}', [SuratController::class, 'show']);
    Route::post('/', [SuratController::class, 'store']);
    Route::put('/{id}', [SuratController::class, 'update']);
    Route::delete('/{id}', [SuratController::class, 'destroy']);
});