<?php

namespace Database\Seeders\GeneralSeeder;

use App\Models\RefJabatanPerangkat;
use Illuminate\Database\Seeder;

class RefJabatanPerangkatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            [
                'kode' => 'KADES',
                'nama' => 'Kepala Desa',
                'deskripsi' => 'Pimpinan Pemerintah Desa',
                'urutan' => 1,
                'aktif' => true,
                'dapat_menandatangani' => true,
            ],

            [
                'kode' => 'SEKDES',
                'nama' => 'Sekretaris Desa',
                'deskripsi' => 'Membantu Kepala Desa dalam administrasi pemerintahan',
                'urutan' => 2,
                'aktif' => true,
                'dapat_menandatangani' => true,
            ],

            [
                'kode' => 'KAUR_TU',
                'nama' => 'Kepala Urusan Tata Usaha dan Umum',
                'deskripsi' => 'Mengelola administrasi umum dan tata usaha',
                'urutan' => 3,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'KAUR_KEU',
                'nama' => 'Kepala Urusan Keuangan',
                'deskripsi' => 'Mengelola administrasi keuangan desa',
                'urutan' => 4,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'KAUR_PER',
                'nama' => 'Kepala Urusan Perencanaan',
                'deskripsi' => 'Mengelola perencanaan pembangunan desa',
                'urutan' => 5,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'KASI_PEM',
                'nama' => 'Kepala Seksi Pemerintahan',
                'deskripsi' => 'Menyelenggarakan urusan pemerintahan desa',
                'urutan' => 6,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'KASI_KES',
                'nama' => 'Kepala Seksi Kesejahteraan',
                'deskripsi' => 'Mengelola bidang kesejahteraan masyarakat',
                'urutan' => 7,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'KASI_PEL',
                'nama' => 'Kepala Seksi Pelayanan',
                'deskripsi' => 'Mengelola pelayanan kepada masyarakat',
                'urutan' => 8,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'KADUS',
                'nama' => 'Kepala Dusun',
                'deskripsi' => 'Memimpin wilayah dusun',
                'urutan' => 9,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            // Jabatan yang cukup sering ditemui
            [
                'kode' => 'STAF_ADM',
                'nama' => 'Staf Administrasi',
                'deskripsi' => 'Membantu administrasi pemerintahan desa',
                'urutan' => 10,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'STAF_KEU',
                'nama' => 'Staf Keuangan',
                'deskripsi' => 'Membantu pengelolaan keuangan desa',
                'urutan' => 11,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'STAF_PER',
                'nama' => 'Staf Perencanaan',
                'deskripsi' => 'Membantu penyusunan perencanaan desa',
                'urutan' => 12,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'STAF_PEL',
                'nama' => 'Staf Pelayanan',
                'deskripsi' => 'Membantu pelayanan administrasi masyarakat',
                'urutan' => 13,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'OP_DESA',
                'nama' => 'Operator Desa',
                'deskripsi' => 'Mengelola aplikasi dan sistem informasi desa',
                'urutan' => 14,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'BENDAHARA',
                'nama' => 'Bendahara Desa',
                'deskripsi' => 'Mengelola kas desa apabila dipisahkan dari Kaur Keuangan',
                'urutan' => 15,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'ARSIP',
                'nama' => 'Pengelola Arsip',
                'deskripsi' => 'Mengelola arsip dan dokumen desa',
                'urutan' => 16,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'UMUM',
                'nama' => 'Staf Umum',
                'deskripsi' => 'Membantu tugas umum pemerintahan desa',
                'urutan' => 17,
                'aktif' => true,
                'dapat_menandatangani' => false,
            ],
        ];

        foreach ($data as $item) {
            RefJabatanPerangkat::updateOrCreate(
                ['kode' => $item['kode']],
                $item
            );
        }
    }
}