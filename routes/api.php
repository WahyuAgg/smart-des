<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WilayahController;


Route::middleware([
    'auth:sanctum',
    'role:admin|petugas|kepala_desa',
])->group(function () {

    Route::apiResource('alamat', App\Http\Controllers\Api\AlamatController::class);
    Route::apiResource('inv-barang', App\Http\Controllers\Api\InvBarangController::class);
    Route::apiResource('inv-detail-peminjaman', App\Http\Controllers\Api\InvDetailPeminjamanController::class);
    Route::apiResource('inv-kategori-barang', App\Http\Controllers\Api\InvKategoriBarangController::class);
    Route::apiResource('inv-lokasi', App\Http\Controllers\Api\InvLokasiController::class);
    Route::apiResource('inv-peminjaman', App\Http\Controllers\Api\InvPeminjamanController::class);
    Route::apiResource('kk', App\Http\Controllers\Api\KkController::class);
    Route::apiResource('pekerjaan', App\Http\Controllers\Api\PekerjaanController::class);
    Route::apiResource('pendidikan', App\Http\Controllers\Api\PendidikanController::class);
    Route::apiResource('penduduk', App\Http\Controllers\Api\PendudukController::class);
    Route::apiResource('ref-dusun', App\Http\Controllers\Api\RefDusunController::class);
    Route::apiResource('ref-jabatan-perangkat', App\Http\Controllers\Api\RefJabatanPerangkatController::class);
    Route::apiResource('ref-perangkat-desa', App\Http\Controllers\Api\RefPerangkatDesaController::class);
    Route::apiResource('ref-profil-desa', App\Http\Controllers\Api\RefProfilDesaController::class);
    Route::apiResource('ref-rt', App\Http\Controllers\Api\RefRtController::class);
    Route::apiResource('ref-rw', App\Http\Controllers\Api\RefRwController::class);
    Route::apiResource('srt-jenis-surat', App\Http\Controllers\Api\SrtJenisSuratController::class);
    Route::apiResource('srt-jenis-surat-field', App\Http\Controllers\Api\SrtJenisSuratFieldController::class);
    Route::apiResource('srt-kategori-surat', App\Http\Controllers\Api\SrtKategoriSuratController::class);
    Route::apiResource('srt-master-field-surat', App\Http\Controllers\Api\SrtMasterFieldSuratController::class);
    Route::apiResource('srt-pengajuan-surat', App\Http\Controllers\Api\SrtPengajuanSuratController::class);
    Route::apiResource('users', App\Http\Controllers\Api\UserController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/refresh', [AuthController::class, 'refresh']);
});


Route::post('/login', [AuthController::class, 'login']);

Route::get('/wilayah', [WilayahController::class, 'index']);

