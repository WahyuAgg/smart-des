<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\RefPerangkatDesa;
use App\Models\RefProfilDesa;
use Illuminate\Http\JsonResponse;

class FullModelAccessorController extends Controller
{
    /**
     * Return RefProfilDesa dengan semua atribut + accessor.
     */
    public function profilDesa(): JsonResponse
    {
        $record = RefProfilDesa::query()->first();

        if (! $record) {
            return response()->json(['message' => 'Profil desa belum diisi.'], 404);
        }

        // Panggil semua accessor secara eksplisit agar ikut dalam response
        $record->append([
            'logo_url',
            'peta_pdf_url',
            'kades',
            'sekdes',
            'bendahara',
            'kaur_tu',
            'kaur_keu',
            'kaur_per',
            'kasi_pem',
            'kasi_kes',
            'kasi_pel',
            'kepala_dusun',
            'staf_adm',
            'staf_keu',
            'staf_per',
            'staf_pel',
            'operator_desa',
            'pengelola_arsip',
            'staf_umum',
            'desa',
            'kecamatan',
            'kabupaten',
            'provinsi',
            'nama_provinsi',
            'nama_kabupaten',
            'nama_kecamatan',
            'nama_desa',
            'kode_pos',
            'profil_kecamatan',
        ]);

        return response()->json($record);
    }

    /**
     * Return Penduduk by ID dengan semua atribut + accessor + relasi.
     */
    public function penduduk(int $id): JsonResponse
    {
        $record = Penduduk::with(['kk', 'alamat', 'pendidikan'])->find($id);

        if (! $record) {
            return response()->json(['message' => 'Penduduk tidak ditemukan.'], 404);
        }

        $record->append([
            'tanggal_lahir_f',
            'umur',
            'no_kk',
            'nama_pendidikan',
            'get_alamat',
        ]);

        return response()->json($record);
    }

    /**
     * Return RefPerangkatDesa by ID dengan semua atribut + relasi jabatan.
     */
    public function perangkatDesa(int $id): JsonResponse
    {
        $record = RefPerangkatDesa::with('jabatanPerangkat')->find($id);

        if (! $record) {
            return response()->json(['message' => 'Perangkat desa tidak ditemukan.'], 404);
        }

        return response()->json($record);
    }
}