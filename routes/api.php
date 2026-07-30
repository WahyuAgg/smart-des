<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SrtPengajuanSuratController;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\Api\SrtJenisSuratController;

use App\Http\Controllers\TestingController;

// use App\Http\Controllers\Api\AlamatController;
use App\Http\Controllers\Api\AppInfoController;
use App\Http\Controllers\Api\InvBarangController;
use App\Http\Controllers\Api\InvDetailMutasiController;
use App\Http\Controllers\Api\InvDetailPeminjamanController;
use App\Http\Controllers\Api\InvKategoriBarangController;
use App\Http\Controllers\Api\InvLokasiController;
use App\Http\Controllers\Api\InvMutasiController;
use App\Http\Controllers\Api\InvPeminjamanController;
use App\Http\Controllers\Api\KkController;
use App\Http\Controllers\Api\PekerjaanController;
use App\Http\Controllers\Api\PendidikanController;
use App\Http\Controllers\Api\PendudukController;
use App\Http\Controllers\Api\RefDusunController;
use App\Http\Controllers\Api\RefJabatanPerangkatController;
use App\Http\Controllers\Api\RefPerangkatDesaController;
use App\Http\Controllers\Api\RefProfilDesaController;
use App\Http\Controllers\Api\RefRtController;
use App\Http\Controllers\Api\RefRwController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SrtKategoriSuratController;
use App\Http\Controllers\Api\SrtMasterFieldSuratController;
use App\Http\Controllers\Api\BackupController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PaperController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GaleriController;

// -----------------------------------------------------------------
// Protected route
// This route is protected by auth:sanctum and role middleware.
// -----------------------------------------------------------------

/**
 * This is protected by auth:sanctum and role middleware.
 * Only users with roles 'admin', 'petugas', or 'kepala_desa' can access these routes.
 */
Route::middleware([
    'auth:sanctum',
    'role:admin|petugas|kepala_desa',
])->group(function () {

    // Helper: list all available roles for dropdowns
    Route::get('roles', [RoleController::class, 'index']);

    /**
     * Route for ref-profile-desa
     * This route does not use ID since supposedly there's only one object of prfil desa
     * and this system will only manage one desa. So, the ID is not needed.
     * 
     * TODO: If in the future, this system will manage multiple desa, then we need to add ID to these routes.
     */
    Route::put('ref-profil-desa', [RefProfilDesaController::class, 'updateProfilDesa']);
    Route::post('ref-profil-desa', [RefProfilDesaController::class, 'storeProfilDesa']);
    Route::delete('ref-profil-desa', [RefProfilDesaController::class, 'deleteProfilDesa']);


    /**
     * Route for managing master data Desa
     * Like arious reference data like KK, pekerjaan, pendidikan, dusun, jabatan perangkat, perangkat desa, RT, RW.
     */
    Route::apiResource('penduduk', PendudukController::class);
    Route::apiResource('kk', KkController::class);
    Route::apiResource('pekerjaan', PekerjaanController::class);
    Route::apiResource('pendidikan', PendidikanController::class);
    Route::apiResource('ref-dusun', RefDusunController::class);
    Route::apiResource('ref-jabatan-perangkat', RefJabatanPerangkatController::class);
    Route::apiResource('ref-perangkat-desa', RefPerangkatDesaController::class);
    Route::apiResource('ref-rt', RefRtController::class);
    Route::apiResource('ref-rw', RefRwController::class);




    /**
     * Route for managing inventory data
     * Like various reference data like kategori barang, lokasi, barang, peminjaman, mutasi, detail peminjaman, detail mutasi.
     */

    // Endpoints for kategori barang dan lokasi
    Route::apiResource('inv-kategori-barang', InvKategoriBarangController::class);
    Route::apiResource('inv-lokasi', InvLokasiController::class);
    Route::apiResource('inv-barang', InvBarangController::class);

    // Endpoint mutasi stok pada barang
    Route::post('inv-barang/{id}/pengadaan', [InvBarangController::class, 'pengadaan']);
    Route::post('inv-barang/{id}/hilang', [InvBarangController::class, 'hilang']);
    Route::post('inv-barang/{id}/ketemu', [InvBarangController::class, 'ketemu']);
    Route::post('inv-barang/{id}/opname', [InvBarangController::class, 'opname']);
    Route::post('inv-barang/{id}/hapus-stok', [InvBarangController::class, 'hapusStok']);

    // Riwayat & mutasi per barang
    Route::get('inv-barang/{id}/riwayat-mutasi', [InvBarangController::class, 'mutasi']);
    Route::get('inv-barang/{id}/riwayat-peminjaman', [InvBarangController::class, 'riwayat']);

    // Endpoint khusus peminjaman
    Route::apiResource('inv-detail-peminjaman', InvDetailPeminjamanController::class);
    Route::apiResource('inv-peminjaman', InvPeminjamanController::class);
    Route::post('inv-peminjaman/{id}/kembalikan', [InvPeminjamanController::class, 'kembalikan']);
    Route::post('inv-peminjaman/{id}/batalkan', [InvPeminjamanController::class, 'batalkan']);

    // Buku Besar Mutasi (Stock Ledger)
    Route::apiResource('inv-mutasi', InvMutasiController::class)->only(['index', 'show', 'store', 'destroy']);
    Route::apiResource('inv-detail-mutasi', InvDetailMutasiController::class)->only(['index', 'show']);

    /**
     * Route for managing system data, like User as user in this system is considered as part of the system setting separate from reference data like "penduduk".
     * More utility for this route will be added  later
     */
    Route::apiResource('users', UserController::class);
    Route::post('users/{user}/toggle-active', [UserController::class, 'toggleActive']);

    /**
     * Route for Backup
     */
    Route::get('backup', [BackupController::class, 'backup']);
    Route::get('backup/download', [BackupController::class, 'download']);

    /**
     * Route for Paper
     */
    Route::post('papers', [PaperController::class, 'store']);

    Route::put('papers/{paper}', [PaperController::class, 'update']);

    Route::delete('papers/{paper}', [PaperController::class, 'destroy']);
    /**
     * Route for Galeri (Gallery)
     */
    Route::post('galeri', [GaleriController::class, 'store']);
    Route::put('galeri/{galeri}', [GaleriController::class, 'update']);
    Route::delete('galeri/{galeri}', [GaleriController::class, 'destroy']);

    /**
     * Route for Dashboard
     */
    Route::get('dashboard', [DashboardController::class, 'index']);

    /**
     * Currently this route is not used, but it can be used in the future if needed.
     * Directly accessing alamat data is not recommended, because alamat data should be managed through penduduk and other related data.
     * So, this route is commented out for now.
     */
    // Route::apiResource('alamat', AlamatController::class);


    /** Route for managing user and roles */
    Route::get('/roles', [RoleController::class, 'index']);
});


/**
 * These routes are for authentication.
 * They include login, logout, refresh token, and getting the authenticated user's information.
 * This route only protected by sanctun and NOT by role middleware, because this route is used for authentication and user management, and it should be accessible to all authenticated users regardless of their role.
 */
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::post('/logout', [AuthController::class, 'logout']);
});



// -----------------------------------------------------------------
// Public route
// This route is not protected, and does not require token to access them
// -----------------------------------------------------------------


/** Route for login 
 * As for logout route in the protected group as it needs user token to logout, and it will be handled by the AuthController.
 */
Route::post('/login', [AuthController::class, 'login']);

/** Route for testing purposes */
Route::get('/testing', [TestingController::class, 'testing']);

/** Route for app info */
Route::get('/app-info', [AppInfoController::class, 'info']);


/**
 * Route for accessing data Wilayah in indonesia
 * This route typically be used for references only when filling data that require data wilayah such as address (alamat)
 */
Route::get('/wilayah', [WilayahController::class, 'index']);
Route::get('/wilayah/level/{level}/id/{id}', [WilayahController::class, 'showById']);
Route::get('/wilayah/level/{level}/code/{code}', [WilayahController::class, 'showByCode']);
/**
 * Route for Paper — public read access
 */
Route::get('/papers', [PaperController::class, 'index']);
Route::get('/papers/{id}', [PaperController::class, 'show']);

/**
 * Route Ini digunakan untuk pengajuan surat wizard. 
 * currently no authentication or role middleware is applied to these routes, but you may want to add them based on your application's requirements.
 */
Route::apiResource('srt-jenis-surat', SrtJenisSuratController::class);

Route::get('srt-pengajuan-surat', [SrtPengajuanSuratController::class, 'index']);
Route::post('srt-pengajuan-surat', [SrtPengajuanSuratController::class, 'store']);
Route::get('srt-pengajuan-surat/{srt_pengajuan_surat}', [SrtPengajuanSuratController::class, 'show']);
Route::post('/pengajuan-surat', [SrtPengajuanSuratController::class, 'store']);
Route::post('/pengajuan-surat/{id}', [SrtPengajuanSuratController::class, 'update']);

Route::apiResource('srt-kategori-surat', SrtKategoriSuratController::class);
Route::apiResource('srt-master-field-surat', SrtMasterFieldSuratController::class);

Route::match(['put', 'patch'], 'srt-pengajuan-surat/{srt_pengajuan_surat}', [SrtPengajuanSuratController::class, 'update']);
// Route::delete('srt-pengajuan-surat/{srt_pengajuan_surat}', [SrtPengajuanSuratController::class, 'destroy']);



// Profil desa
Route::get('ref-profil-desa', [RefProfilDesaController::class, 'showProfilDesa']);


// Fetch Galeri
Route::get('galeri', [GaleriController::class, 'index']);
Route::get('galeri/{galeri}', [GaleriController::class, 'show']);
