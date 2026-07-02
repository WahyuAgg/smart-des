<?php

namespace Database\Seeders\GeneralSeeder;

use App\Models\SrtJenisSurat;
use App\Models\SrtKategoriSurat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriKeterangan = SrtKategoriSurat::query()->where('kode_kategori_surat', 'KET')->firstOrFail();
        $kategoriPengantar = SrtKategoriSurat::query()->where('kode_kategori_surat', 'PENG')->firstOrFail();

        $data = [

            [
                'kategori_surat_id' => $kategoriKeterangan->id,
                'kode_jenis_surat' => 'SKP',
                'nama_jenis_surat' => 'Surat Keterangan Domisili Penduduk',
                'deskripsi' => 'Surat keterangan yang menerangkan status seseorang sebagai penduduk desa.',
                'template_path'=> 'app/templates/domisili_temp.docx',
                'is_active' => true,
            ],

            [
                'kategori_surat_id' => $kategoriKeterangan->id,
                'kode_jenis_surat' => 'SKD',
                'nama_jenis_surat' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Surat keterangan mengenai domisili atau tempat tinggal penduduk.',
                'is_active' => true,
            ],

            [
                'kategori_surat_id' => $kategoriKeterangan->id,
                'kode_jenis_surat' => 'SKTM',
                'nama_jenis_surat' => 'Surat Keterangan Tidak Mampu',
                'deskripsi' => 'Surat keterangan untuk keperluan bantuan sosial, pendidikan, atau layanan lainnya.',
                'is_active' => true,
            ],

            [
                'kategori_surat_id' => $kategoriKeterangan->id,
                'kode_jenis_surat' => 'SKU',
                'nama_jenis_surat' => 'Surat Keterangan Usaha',
                'deskripsi' => 'Surat keterangan bahwa penduduk memiliki atau menjalankan suatu usaha.',
                'is_active' => true,
            ],

            [
                'kategori_surat_id' => $kategoriKeterangan->id,
                'kode_jenis_surat' => 'SKL',
                'nama_jenis_surat' => 'Surat Keterangan Kelahiran',
                'deskripsi' => 'Surat keterangan atas peristiwa kelahiran.',
                'is_active' => true,
            ],

            [
                'kategori_surat_id' => $kategoriKeterangan->id,
                'kode_jenis_surat' => 'SKM',
                'nama_jenis_surat' => 'Surat Keterangan Kematian',
                'deskripsi' => 'Surat keterangan atas peristiwa kematian.',
                'is_active' => true,
            ],

            [
                'kategori_surat_id' => $kategoriPengantar->id,
                'kode_jenis_surat' => 'SPN',
                'nama_jenis_surat' => 'Surat Pengantar Nikah',
                'deskripsi' => 'Surat pengantar untuk keperluan pencatatan perkawinan di KUA atau instansi terkait.',
                'is_active' => true,
            ],

        ];

        foreach ($data as $item) {
            SrtJenisSurat::updateOrCreate(
                [
                    'kode_jenis_surat' => $item['kode_jenis_surat'],
                ],
                $item
            );
        }
    }
}