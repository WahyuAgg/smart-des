<?php

namespace Database\Seeders\GeneralSeeder\MasterFieldSurat;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SrtMasterFieldSurat;


class ProfilDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [

            // PROFIL DESA
            ['nama' => 'ref_nama_desa', 'label' => 'Nama Desa', 'source' => 'profil_desa', 'source_field' => 'nama_desa', 'input_mode' => 'auto'],
            ['nama' => 'ref_alamat_kantor', 'label' => 'Alamat Kantor', 'source' => 'profil_desa', 'source_field' => 'alamat', 'input_mode' => 'auto'],
            ['nama' => 'ref_kode_pos_desa', 'label' => 'Kode Pos Desa', 'source' => 'profil_desa', 'source_field' => 'kode_pos', 'input_mode' => 'auto'],
            ['nama' => 'ref_telepon_desa', 'label' => 'Telepon Desa', 'source' => 'profil_desa', 'source_field' => 'telepon', 'input_mode' => 'auto'],
            ['nama' => 'ref_email_desa', 'label' => 'Email Desa', 'source' => 'profil_desa', 'source_field' => 'email', 'input_mode' => 'auto'],
            ['nama' => 'ref_website_desa', 'label' => 'Website Desa', 'source' => 'profil_desa', 'source_field' => 'website', 'input_mode' => 'auto'],
            ['nama' => 'ref_kecamatan', 'label' => 'Kecamatan', 'source' => 'profil_desa', 'source_field' => 'nama_kecamatan', 'input_mode' => 'auto'],
            ['nama' => 'ref_kabupaten', 'label' => 'Kabupaten', 'source' => 'profil_desa', 'source_field' => 'nama_kabupaten', 'input_mode' => 'auto'],
            ['nama' => 'ref_provinsi', 'label' => 'Provinsi', 'source' => 'profil_desa', 'source_field' => 'nama_provinsi', 'input_mode' => 'auto'],


            // KECAMATAN CAMAT
            ['nama' => 'nama_kecamatan', 'label' => 'Nama Kecamatan', 'source' => 'profil_desa', 'source_field' => 'profile_kecamatan.nama', 'input_mode' => 'auto'],
            ['nama' => 'nama_camat', 'label' => 'Nama Camat', 'source' => 'profil_desa', 'source_field' => 'profile_kecamatan.camat', 'input_mode' => 'auto'],
            ['nama' => 'nip_camat', 'label' => 'NIP Camat', 'source' => 'profil_desa', 'source_field' => 'profile_kecamatan.nip', 'input_mode' => 'auto'],
            ['nama' => 'telepon_camat', 'label' => 'Telepon Camat', 'source' => 'profil_desa', 'source_field' => 'profile_kecamatan.telepon', 'input_mode' => 'auto'],
            ['nama' => 'email_camat', 'label' => 'Email Camat', 'source' => 'profil_desa', 'source_field' => 'profile_kecamatan.email', 'input_mode' => 'auto'],
            ['nama' => 'foto_camat', 'label' => 'Foto Camat', 'source' => 'profil_desa', 'source_field' => 'profile_kecamatan.foto', 'input_mode' => 'auto'],
            ['nama' => 'tanda_tangan_camat', 'label' => 'Tanda Tangan Camat', 'source' => 'profil_desa', 'source_field' => 'profile_kecamatan.tanda_tangan', 'input_mode' => 'auto'],


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
