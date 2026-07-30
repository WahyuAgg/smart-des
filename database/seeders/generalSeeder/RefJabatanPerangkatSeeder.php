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
                'kode' => 'kades',
                'nama' => 'Kepala Desa',
                'deskripsi' => 'Pimpinan Pemerintah Desa',
                'urutan' => 1,
                'aktif' => true,
                'dapat_menandatangani' => true,
            ],

            [
                'kode' => 'sekdes',
                'nama' => 'Sekretaris Desa',
                'deskripsi' => 'Membantu Kepala Desa dalam administrasi pemerintahan',
                'urutan' => 2,
                'aktif' => true,
                'dapat_menandatangani' => true,
            ],

            [
                'kode' => 'kaur_tu',
                'nama' => 'Kepala Urusan Tata Usaha dan Umum',
                'deskripsi' => 'Mengelola administrasi umum dan tata usaha',
                'urutan' => 3,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'kaur_keu',
                'nama' => 'Kepala Urusan Keuangan',
                'deskripsi' => 'Mengelola administrasi keuangan desa',
                'urutan' => 4,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'kaur_per',
                'nama' => 'Kepala Urusan Perencanaan',
                'deskripsi' => 'Mengelola perencanaan pembangunan desa',
                'urutan' => 5,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'kasi_pem',
                'nama' => 'Kepala Seksi Pemerintahan',
                'deskripsi' => 'Menyelenggarakan urusan pemerintahan desa',
                'urutan' => 6,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'kasi_kes',
                'nama' => 'Kepala Seksi Kesejahteraan',
                'deskripsi' => 'Mengelola bidang kesejahteraan masyarakat',
                'urutan' => 7,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'kasi_pel',
                'nama' => 'Kepala Seksi Pelayanan',
                'deskripsi' => 'Mengelola pelayanan kepada masyarakat',
                'urutan' => 8,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'kadus',
                'nama' => 'Kepala Dusun',
                'deskripsi' => 'Memimpin wilayah dusun',
                'urutan' => 9,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            // Jabatan yang cukup sering ditemui
            [
                'kode' => 'staf_adm',
                'nama' => 'Staf Administrasi',
                'deskripsi' => 'Membantu administrasi pemerintahan desa',
                'urutan' => 10,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'staf_keu',
                'nama' => 'Staf Keuangan',
                'deskripsi' => 'Membantu pengelolaan keuangan desa',
                'urutan' => 11,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'staf_per',
                'nama' => 'Staf Perencanaan',
                'deskripsi' => 'Membantu penyusunan perencanaan desa',
                'urutan' => 12,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'staf_pel',
                'nama' => 'Staf Pelayanan',
                'deskripsi' => 'Membantu pelayanan administrasi masyarakat',
                'urutan' => 13,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'op_desa',
                'nama' => 'Operator Desa',
                'deskripsi' => 'Mengelola aplikasi dan sistem informasi desa',
                'urutan' => 14,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'bendahara',
                'nama' => 'Bendahara Desa',
                'deskripsi' => 'Mengelola kas desa apabila dipisahkan dari Kaur Keuangan',
                'urutan' => 15,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'arsip',
                'nama' => 'Pengelola Arsip',
                'deskripsi' => 'Mengelola arsip dan dokumen desa',
                'urutan' => 16,
                'aktif' => false,
                'dapat_menandatangani' => false,
            ],

            [
                'kode' => 'umum',
                'nama' => 'Staf Umum',
                'deskripsi' => 'Membantu tugas umum pemerintahan desa',
                'urutan' => 17,
                'aktif' => false,
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