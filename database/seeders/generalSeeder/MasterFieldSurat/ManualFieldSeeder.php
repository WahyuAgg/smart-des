<?php

namespace Database\Seeders\GeneralSeeder\MasterFieldSurat;

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
            // INPUT MANUAL
            ['nama' => 'keperluan', 'label' => 'Keperluan', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],
            ['nama' => 'tujuan', 'label' => 'Tujuan', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'keterangan', 'label' => 'Keterangan', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],
            ['nama' => 'keterangan_lain', 'label' => 'Keterangan', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],
            ['nama' => 'catatan', 'label' => 'Catatan', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],
            ['nama' => 'sekolah', 'label' => 'Sekolah', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            // ['nama' => 'tanggal', 'label' => 'Tanggal', 'source' => null, 'source_field' => null, 'tipe' => 'date', 'input_mode' => 'manual'],
            ['nama' => 'nama_usaha', 'label' => 'Nama Usaha', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'jenis_usaha', 'label' => 'Jenis Usaha', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'alamat_usaha', 'label' => 'Alamat Usaha', 'source' => null, 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'manual'],
            ['nama' => 'luas_tanah', 'label' => 'Luas Tanah', 'source' => null, 'source_field' => null, 'tipe' => 'number', 'input_mode' => 'manual'],
            ['nama' => 'nomor_sertifikat', 'label' => 'Nomor Sertifikat', 'source' => null, 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'manual'],
            ['nama' => 'lama_usaha', 'label' => 'Lama Usaha', 'source' => null, 'source_field' => null, 'tipe' => 'number', 'input_mode' => 'manual'],
            ['nama' => 'penghasilan', 'label' => 'Penghasilan', 'source' => null, 'source_field' => null, 'tipe' => 'currency', 'input_mode' => 'manual'],
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
