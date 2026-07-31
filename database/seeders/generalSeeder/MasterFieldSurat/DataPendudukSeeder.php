<?php

namespace Database\Seeders\GeneralSeeder\MasterFieldSurat;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SrtMasterFieldSurat;


class DataPendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            // DATA PENDUDUK
            ['nama' => 'nama_lengkap', 'label' => 'Nama Lengkap', 'source' => 'penduduk', 'source_field' => 'nama_lengkap', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'nama', 'label' => 'Nama', 'source' => 'penduduk', 'source_field' => 'nama_lengkap', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'nik', 'label' => 'NIK', 'source' => 'penduduk', 'source_field' => 'nik', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'no_kk', 'label' => 'Nomor KK', 'source' => 'penduduk', 'source_field' => 'no_kk', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'source' => 'penduduk', 'source_field' => 'tempat_lahir', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'source' => 'penduduk', 'source_field' => 'jenis_kelamin', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'agama', 'label' => 'Agama', 'source' => 'penduduk', 'source_field' => 'agama', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'status_perkawinan', 'label' => 'Status Perkawinan', 'source' => 'penduduk', 'source_field' => 'status_perkawinan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'pekerjaan', 'label' => 'Pekerjaan', 'source' => 'penduduk', 'source_field' => 'pekerjaan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'pendidikan', 'label' => 'Pendidikan', 'source' => 'penduduk', 'source_field' => 'nama_pendidikan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'kewarganegaraan', 'label' => 'Kewarganegaraan', 'source' => 'penduduk', 'source_field' => 'kewarganegaraan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'nama_ayah_kandung', 'label' => 'Nama Ayah Kandung', 'source' => 'penduduk', 'source_field' => 'nama_ayah_kandung', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'nama_ibu_kandung', 'label' => 'Nama Ibu Kandung', 'source' => 'penduduk', 'source_field' => 'nama_ibu_kandung', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'tanggal_lahir', 'label' => 'Tanggal Lahir (date)', 'source' => 'penduduk', 'source_field' => 'tanggal_lahir_formatted', 'tipe' => 'date', 'input_mode' => 'auto'],
            ['nama' => 'tanggal_lahir_f', 'label' => 'Tanggal Lahir', 'source' => 'penduduk', 'source_field' => 'tanggal_lahir_f', 'tipe' => 'date', 'input_mode' => 'auto'],
            ['nama' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'source' => 'penduduk', 'source_field' => 'tanggal_lahir', 'tipe' => 'date', 'input_mode' => 'auto'],

            // Kontak penduduk
            ['nama' => 'nomor_hp_penduduk', 'label' => 'Nomor HP', 'source' => 'penduduk', 'source_field' => 'nomor_hp', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'email_penduduk', 'label' => 'Email', 'source' => 'penduduk', 'source_field' => 'email', 'tipe' => 'email', 'input_mode' => 'auto'],


            // kasus unik, misal untuk surat kematian, bisa menggunakan tanggal tercatat sebagai tanggal lahir
            ['nama' => 'tanggal_domisili', 'label' => 'Tanggal Tercatat (date)', 'source' => 'penduduk', 'source_field' => 'tanggal_lahir', 'tipe' => 'date', 'input_mode' => 'auto_editable'],
            ['nama' => 'tanggal_mati', 'label' => 'Tanggal Kematian', 'source' => 'penduduk', 'source_field' => 'tanggal_maninggal', 'tipe' => 'date', 'input_mode' => 'manual'],
            ['nama' => 'tanggal_domisili_f', 'label' => 'Tanggal Tercatat', 'source' => 'penduduk', 'source_field' => 'tanggal_lahir_f', 'tipe' => 'date', 'input_mode' => 'auto_editable'],
            ['nama' => 'umur', 'label' => 'Umur', 'source' => 'penduduk', 'source_field' => 'umur', 'tipe' => 'number', 'input_mode' => 'auto_editable'],

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
