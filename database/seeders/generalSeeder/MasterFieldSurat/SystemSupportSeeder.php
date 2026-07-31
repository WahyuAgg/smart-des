<?php

namespace Database\Seeders\GeneralSeeder\MasterFieldSurat;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SrtMasterFieldSurat;


class SystemSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [

            // JENIS SURAT
            // ['nama' => 'nama_jenis_surat', 'label' => 'Nama Jenis Surat', 'source' => 'jenis_surat', 'source_field' => 'nama_jenis_surat', 'input_mode' => 'auto'],

            // SISTEM
            ['nama' => 'nomor_surat', 'label' => 'Nomor Surat', 'source' => 'system', 'source_field' => 'nomor_surat', 'input_mode' => 'auto'],
            ['nama' => 'tanggal_surat', 'label' => 'Tanggal Surat', 'source' => 'system', 'source_field' => 'tanggal_surat', 'input_mode' => 'auto'],
            ['nama' => 'tanggal_cetak', 'label' => 'Tanggal Cetak', 'source' => 'system', 'source_field' => 'tanggal_cetak', 'input_mode' => 'auto'],
            ['nama' => 'tahun', 'label' => 'Tahun ini', 'source' => 'system', 'source_field' => 'tahun', 'input_mode' => 'auto'],
            ['nama' => 'bulan', 'label' => 'Bulan ini', 'source' => 'system', 'source_field' => 'bulan', 'input_mode' => 'auto'],
            ['nama' => 'tanggal', 'label' => 'Tanggal ini', 'source' => 'system', 'source_field' => 'tanggal', 'input_mode' => 'auto'],
            ['nama' => 'hari', 'label' => 'Hari ini', 'source' => 'system', 'source_field' => 'hari', 'input_mode' => 'auto'],

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
