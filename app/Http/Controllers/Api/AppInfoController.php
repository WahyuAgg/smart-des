<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class AppInfoController extends ApiController
{
    public function info(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Informasi aplikasi berhasil diambil.',
            'data' => [
                'nama' => 'SmartDes',
                'versi' => '1.0.0',
                'developer' => 'Wahyu',
                'institusi' => 'Sekolah Vokasi Universitas Gadjah Mada',
                'program' => 'KKN-PPM UGM 2026',
                'tujuan' => 'Mendukung digitalisasi administrasi desa.',

                'teknologi' => [
                    'Laravel 12',
                    'PHP 8.2',
                    'MySQL',
                    'Vite',
                ],

                'lisensi' => 'Proprietary',

                'ucapan_terima_kasih' => [
                    'Universitas Gadjah Mada',
                    'Pemerintah dan Masyarakat Desa Curug',
                    'Tim KKN-PPM UGM 2026 JT-155',
                    'Seluruh pihak yang telah mendukung pengembangan aplikasi ini.',
                ],

                'copyright' => '© 2026 Wahyu. All Rights Reserved.',
            ],
        ]);
    }
}