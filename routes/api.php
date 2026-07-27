<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SrtPengajuanSuratController;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\Api\SrtJenisSuratController;

use App\Http\Controllers\TestingController;


/**
 * Route Ini digunakan untuk pengajuan surat wizard. 
 * currently no authentication or role middleware is applied to these routes, but you may want to add them based on your application's requirements.
 */
Route::get('/jenis-surat', [SrtJenisSuratController::class,'index']);
Route::get('/jenis-surat/{id}', [SrtJenisSuratController::class,'show']);
Route::post('/pengajuan-surat', [SrtPengajuanSuratController::class,'store' ]);
Route::post('/pengajuan-surat/{id}', [SrtPengajuanSuratController::class,'update']);


/** 
 * Route Override
 */

Route::middleware([
    'auth:sanctum',
    'role:admin|petugas|kepala_desa',
])->group(function () {

    // Route::apiResource('ref-profil-desa', App\Http\Controllers\Api\RefProfilDesaController::class);
    // Route::get('ref-prifil-desa', [App\Http\Controllers\Api\RefProfilDesaController::class, 'show']);
});




/**
 * This route is user for managing master data, and it is protected by auth:sanctum and role middleware.
 * Only users with roles 'admin', 'petugas', or 'kepala_desa' can access these routes.
 */
Route::middleware([
    'auth:sanctum',
    'role:admin|petugas|kepala_desa',
])->group(function () {
    Route::apiResource('srt-master-field-surat', App\Http\Controllers\Api\SrtMasterFieldSuratController::class);


    Route::apiResource('penduduk', App\Http\Controllers\Api\PendudukController::class);

    Route::apiResource('alamat', App\Http\Controllers\Api\AlamatController::class);
    Route::apiResource('inv-barang', App\Http\Controllers\Api\InvBarangController::class);
    // Endpoint mutasi stok pada barang
    Route::post('inv-barang/{id}/pengadaan', [App\Http\Controllers\Api\InvBarangController::class, 'pengadaan']);
    Route::post('inv-barang/{id}/hilang', [App\Http\Controllers\Api\InvBarangController::class, 'hilang']);
        Route::post('inv-barang/{id}/ketemu', [App\Http\Controllers\Api\InvBarangController::class, 'ketemu']);

    Route::post('inv-barang/{id}/opname', [App\Http\Controllers\Api\InvBarangController::class, 'opname']);
    Route::post('inv-barang/{id}/hapus-stok', [App\Http\Controllers\Api\InvBarangController::class, 'hapusStok']);

    Route::apiResource('inv-detail-peminjaman', App\Http\Controllers\Api\InvDetailPeminjamanController::class);

    Route::apiResource('inv-kategori-barang', App\Http\Controllers\Api\InvKategoriBarangController::class);
    Route::apiResource('inv-lokasi', App\Http\Controllers\Api\InvLokasiController::class);

    Route::apiResource('inv-peminjaman', App\Http\Controllers\Api\InvPeminjamanController::class);
    // Endpoint khusus peminjaman
    Route::post('inv-peminjaman/{id}/kembalikan', [App\Http\Controllers\Api\InvPeminjamanController::class, 'kembalikan']);
    Route::post('inv-peminjaman/{id}/batalkan', [App\Http\Controllers\Api\InvPeminjamanController::class, 'batalkan']);

    // Buku Besar Mutasi (Stock Ledger)
    Route::apiResource('inv-mutasi', App\Http\Controllers\Api\InvMutasiController::class)->only(['index', 'show', 'store', 'destroy']);
    Route::apiResource('inv-detail-mutasi', App\Http\Controllers\Api\InvDetailMutasiController::class)->only(['index', 'show']);


    Route::apiResource('kk', App\Http\Controllers\Api\KkController::class);
    Route::apiResource('pekerjaan', App\Http\Controllers\Api\PekerjaanController::class);
    Route::apiResource('pendidikan', App\Http\Controllers\Api\PendidikanController::class);
    Route::apiResource('ref-dusun', App\Http\Controllers\Api\RefDusunController::class);
    Route::apiResource('ref-jabatan-perangkat', App\Http\Controllers\Api\RefJabatanPerangkatController::class);
    Route::apiResource('ref-perangkat-desa', App\Http\Controllers\Api\RefPerangkatDesaController::class);
    Route::apiResource('ref-profil-desa', App\Http\Controllers\Api\RefProfilDesaController::class);
    Route::apiResource('ref-rt', App\Http\Controllers\Api\RefRtController::class);
    Route::apiResource('ref-rw', App\Http\Controllers\Api\RefRwController::class);
    Route::apiResource('srt-jenis-surat', App\Http\Controllers\Api\SrtJenisSuratController::class);
    Route::apiResource('srt-kategori-surat', App\Http\Controllers\Api\SrtKategoriSuratController::class);
    Route::apiResource('srt-pengajuan-surat', App\Http\Controllers\Api\SrtPengajuanSuratController::class);
    Route::apiResource('users', App\Http\Controllers\Api\UserController::class);
});





/**
 * These routes are for authentication and user management.
 * They include login, logout, refresh token, and getting the authenticated user's information.
 */
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
    return $request->user();
    });

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/refresh', [AuthController::class, 'refresh']);
});


/**
 * These routes are for public access and do not require authentication.
 */
Route::post('/login', [AuthController::class, 'login']);

Route::get('/testing', [TestingController::class, 'testing']);


// Route Wilayah

Route::get('/wilayah', [WilayahController::class, 'index']);
Route::get('/wilayah/level/{level}/id/{id}', [WilayahController::class, 'showById']);
Route::get('/wilayah/level/{level}/code/{code}', [WilayahController::class, 'showByCode']);
