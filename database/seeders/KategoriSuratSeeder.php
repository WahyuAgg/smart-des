<?php

namespace Database\Seeders;

use App\Models\KategoriSurat;
use Illuminate\Database\Seeder;

class KategoriSuratSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            [
                'kode_kategori_surat' => 'KET',
                'nama_kategori_surat' => 'Surat Keterangan',
                'deskripsi' => 'Berbagai surat yang menerangkan suatu kondisi, status, atau keadaan seseorang.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'PENG',
                'nama_kategori_surat' => 'Surat Pengantar',
                'deskripsi' => 'Surat pengantar untuk pengurusan dokumen atau layanan pada instansi lain.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'PERNY',
                'nama_kategori_surat' => 'Surat Pernyataan',
                'deskripsi' => 'Surat yang berisi pernyataan atau pengakuan dari pemohon.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'REK',
                'nama_kategori_surat' => 'Surat Rekomendasi',
                'deskripsi' => 'Surat rekomendasi yang diterbitkan pemerintah desa.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'DOM',
                'nama_kategori_surat' => 'Surat Domisili',
                'deskripsi' => 'Surat yang berkaitan dengan domisili penduduk maupun usaha.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'USAHA',
                'nama_kategori_surat' => 'Surat Usaha',
                'deskripsi' => 'Surat yang berkaitan dengan kegiatan usaha masyarakat.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'TANAH',
                'nama_kategori_surat' => 'Surat Pertanahan',
                'deskripsi' => 'Surat mengenai tanah, kepemilikan, batas, dan riwayat tanah.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'NIKAH',
                'nama_kategori_surat' => 'Surat Pernikahan',
                'deskripsi' => 'Surat yang berkaitan dengan administrasi perkawinan.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'PDDK',
                'nama_kategori_surat' => 'Surat Kependudukan',
                'deskripsi' => 'Surat administrasi kependudukan.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'SOS',
                'nama_kategori_surat' => 'Surat Bantuan Sosial',
                'deskripsi' => 'Surat untuk pengajuan atau persyaratan bantuan sosial.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'WARIS',
                'nama_kategori_surat' => 'Surat Waris',
                'deskripsi' => 'Surat yang berkaitan dengan ahli waris dan pewarisan.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'PERIZ',
                'nama_kategori_surat' => 'Surat Perizinan',
                'deskripsi' => 'Surat izin atau rekomendasi kegiatan tertentu.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'LEGAL',
                'nama_kategori_surat' => 'Legalisasi Dokumen',
                'deskripsi' => 'Layanan legalisasi dan pengesahan dokumen.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'KEU',
                'nama_kategori_surat' => 'Surat Keuangan',
                'deskripsi' => 'Surat yang berkaitan dengan penghasilan, rekening, atau administrasi keuangan.',
                'is_active' => true,
            ],

            [
                'kode_kategori_surat' => 'LAIN',
                'nama_kategori_surat' => 'Surat Lainnya',
                'deskripsi' => 'Kategori untuk surat yang belum termasuk kategori lain.',
                'is_active' => true,
            ],

        ];

        foreach ($data as $item) {
            KategoriSurat::updateOrCreate(
                [
                    'kode_kategori_surat' => $item['kode_kategori_surat'],
                ],
                $item
            );

        }
    }
}