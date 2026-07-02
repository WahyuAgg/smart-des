<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'alamat' => App\Http\Controllers\Api\AlamatController::class,
    'inv-barang' => App\Http\Controllers\Api\InvBarangController::class,
    'inv-detail-peminjaman' => App\Http\Controllers\Api\InvDetailPeminjamanController::class,
    'inv-kategori-barang' => App\Http\Controllers\Api\InvKategoriBarangController::class,
    'inv-lokasi' => App\Http\Controllers\Api\InvLokasiController::class,
    'inv-peminjaman' => App\Http\Controllers\Api\InvPeminjamanController::class,
    'kk' => App\Http\Controllers\Api\KkController::class,
    'pekerjaan' => App\Http\Controllers\Api\PekerjaanController::class,
    'pendidikan' => App\Http\Controllers\Api\PendidikanController::class,
    'penduduk' => App\Http\Controllers\Api\PendudukController::class,
    'ref-dusun' => App\Http\Controllers\Api\RefDusunController::class,
    'ref-jabatan-perangkat' => App\Http\Controllers\Api\RefJabatanPerangkatController::class,
    'ref-perangkat-desa' => App\Http\Controllers\Api\RefPerangkatDesaController::class,
    'ref-profil-desa' => App\Http\Controllers\Api\RefProfilDesaController::class,
    'ref-rt' => App\Http\Controllers\Api\RefRtController::class,
    'ref-rw' => App\Http\Controllers\Api\RefRwController::class,
    'srt-jenis-surat' => App\Http\Controllers\Api\SrtJenisSuratController::class,
    'srt-jenis-surat-field' => App\Http\Controllers\Api\SrtJenisSuratFieldController::class,
    'srt-kategori-surat' => App\Http\Controllers\Api\SrtKategoriSuratController::class,
    'srt-master-field-surat' => App\Http\Controllers\Api\SrtMasterFieldSuratController::class,
    'srt-pengajuan-surat' => App\Http\Controllers\Api\SrtPengajuanSuratController::class,
    'users' => App\Http\Controllers\Api\UserController::class,
]);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

