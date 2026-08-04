<?php

namespace Database\Seeders\generalSeeder\MasterFieldSurat;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SrtMasterFieldSurat;


class ManualFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            // ==========================================================
            // UMUM
            // ==========================================================
            ['nama' => 'keperluan', 'label' => 'Keperluan', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],
            ['nama' => 'tujuan', 'label' => 'Tujuan', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'keterangan', 'label' => 'Keterangan', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],
            ['nama' => 'keterangan_lain', 'label' => 'Keterangan', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],
            ['nama' => 'catatan', 'label' => 'Catatan', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],
            ['nama' => 'nomor_surat', 'label' => 'Nomor Surat', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'perihal', 'label' => 'Perihal', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'lampiran', 'label' => 'Lampiran', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'tembusan', 'label' => 'Tembusan', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],

            ['nama' => 'tanggal', 'label' => 'Tanggal', 'source' => null, 'source_field' => null, 'tipe' => 'date', 'input_mode' => 'manual'],
            ['nama' => 'waktu', 'label' => 'Waktu', 'source' => null, 'source_field' => null, 'tipe' => 'time', 'input_mode' => 'manual'],
            ['nama' => 'tempat', 'label' => 'Tempat', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],



            // ==========================================================
            // PENDIDIKAN
            // ==========================================================
            ['nama' => 'sekolah', 'label' => 'Sekolah', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],

            // ==========================================================
            // KEMATIAN
            // ==========================================================
            ['nama' => 'hub_pelapor_meninggal', 'label' => 'Hubungan pelapor dengan yang meninggal', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'jam_meninggal', 'label' => 'Jam Meninggal', 'source' => null, 'source_field' => null, 'tipe' => 'time', 'input_mode' => 'manual'],
            ['nama' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'tempat_makam', 'label' => 'Tempat Pemakaman', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],


            // ==========================================================
            // USAHA
            // ==========================================================
            ['nama' => 'nama_usaha', 'label' => 'Nama Usaha', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'jenis_usaha', 'label' => 'Jenis Usaha', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'alamat_usaha', 'label' => 'Alamat Usaha', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],
            ['nama' => 'lama_usaha', 'label' => 'Lama Usaha', 'source' => null, 'source_field' => null, 'tipe' => 'number', 'input_mode' => 'manual'],
            ['nama' => 'penghasilan', 'label' => 'Penghasilan', 'source' => null, 'source_field' => null, 'tipe' => 'currency', 'input_mode' => 'manual'],

            // ==========================================================
            // PERTANAHAN
            // ==========================================================
            ['nama' => 'luas_tanah', 'label' => 'Luas Tanah', 'source' => null, 'source_field' => null, 'tipe' => 'number', 'input_mode' => 'manual'],
            ['nama' => 'nomor_sertifikat', 'label' => 'Nomor Sertifikat', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
        ];

        foreach ($fields as $field) {

            SrtMasterFieldSurat::updateOrCreate(
                [
                    'nama' => $field['nama'],
                ],
                [
                    'label'         => $field['label'],
                    'source'        => $field['source'],
                    'source_field'  => $field['source_field'],
                    'tipe'          => $field['tipe'] ?? 'text',
                    'opsi'          => $field['opsi'] ?? null,
                    'placeholder'   => $field['placeholder'] ?? null,
                    'keterangan'    => $field['keterangan'] ?? null,
                    'input_mode'    => $field['input_mode'] ?? 'manual',

                ]
            );
        }
    }
}
