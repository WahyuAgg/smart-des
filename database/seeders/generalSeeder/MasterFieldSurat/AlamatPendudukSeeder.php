<?php

namespace Database\Seeders\GeneralSeeder\MasterFieldSurat;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SrtMasterFieldSurat;


class AlamatPendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            // Alamat utama & display
            ['nama' => 'alamat_lengkap', 'label' => 'Alamat Lengkap', 'source' => 'penduduk', 'source_field' => 'get_alamat.alamat_lengkap', 'tipe' => 'textarea', 'input_mode' => 'auto'],
            ['nama' => 'alamat_formatted', 'label' => 'Alamat Lengkap', 'source' => 'penduduk', 'source_field' => 'get_alamat.alamat_formatted', 'tipe' => 'textarea', 'input_mode' => 'auto'],
            ['nama' => 'alamat_label_alamat', 'label' => 'Label Alamat', 'source' => 'penduduk', 'source_field' => 'get_alamat.label_alamat', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_is_utama', 'label' => 'Alamat Utama', 'source' => 'penduduk', 'source_field' => 'get_alamat.is_utama', 'tipe' => 'boolean', 'input_mode' => 'auto'],

            // Detail Bangunan
            ['nama' => 'alamat_gedung_perumahan', 'label' => 'Gedung / Perumahan', 'source' => 'penduduk', 'source_field' => 'get_alamat.gedung_perumahan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_nomor_rumah', 'label' => 'Nomor Rumah', 'source' => 'penduduk', 'source_field' => 'get_alamat.nomor_rumah', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_blok', 'label' => 'Blok', 'source' => 'penduduk', 'source_field' => 'get_alamat.blok', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_no_lantai', 'label' => 'Nomor Lantai', 'source' => 'penduduk', 'source_field' => 'get_alamat.no_lantai', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_no_unit', 'label' => 'Nomor Unit', 'source' => 'penduduk', 'source_field' => 'get_alamat.no_unit', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_patokan', 'label' => 'Patokan / Landmark', 'source' => 'penduduk', 'source_field' => 'get_alamat.patokan', 'tipe' => 'text', 'input_mode' => 'auto'],

            // Detail Lokasi Administrasi
            ['nama' => 'alamat_jalan', 'label' => 'Jalan', 'source' => 'penduduk', 'source_field' => 'get_alamat.jalan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_rt', 'label' => 'RT', 'source' => 'penduduk', 'source_field' => 'get_alamat.rt', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_rw', 'label' => 'RW', 'source' => 'penduduk', 'source_field' => 'get_alamat.rw', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_desa', 'label' => 'Desa / Kelurahan', 'source' => 'penduduk', 'source_field' => 'get_alamat.desa', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_dusun', 'label' => 'Desa / Kelurahan', 'source' => 'penduduk', 'source_field' => 'get_alamat.dusun', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_kecamatan', 'label' => 'Kecamatan', 'source' => 'penduduk', 'source_field' => 'get_alamat.kecamatan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_kabupaten', 'label' => 'Kabupaten / Kota', 'source' => 'penduduk', 'source_field' => 'get_alamat.kabupaten', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_provinsi', 'label' => 'Provinsi', 'source' => 'penduduk', 'source_field' => 'get_alamat.provinsi', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_negara', 'label' => 'Negara', 'source' => 'penduduk', 'source_field' => 'get_alamat.negara', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_kode_pos', 'label' => 'Kode Pos', 'source' => 'penduduk', 'source_field' => 'get_alamat.kode_pos', 'tipe' => 'text', 'input_mode' => 'auto'],

            // Geolokasi
            ['nama' => 'alamat_latitude', 'label' => 'Latitude', 'source' => 'penduduk', 'source_field' => 'get_alamat.latitude', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_longitude', 'label' => 'Longitude', 'source' => 'penduduk', 'source_field' => 'get_alamat.longitude', 'tipe' => 'text', 'input_mode' => 'auto'],
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
