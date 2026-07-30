<?php

namespace Database\Seeders\GeneralSeeder\MasterFieldSurat;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SrtMasterFieldSurat;


class PerangkatDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanList = [
            'kades' => 'Kepala Desa',
            'sekdes' => 'Sekretaris Desa',
            'kaur_tu' => 'Kaur TU',
            'kaur_keu' => 'Kaur Keuangan',
            'kaur_per' => 'Kaur Perencanaan',
            'kasi_pem' => 'Kasi Pemerintahan',
            'kasi_kes' => 'Kasi Kesejahteraan',
            'kasi_pel' => 'Kasi Pelayanan',
            'kadus' => 'Kepala Dusun',
            'staf_adm' => 'Staf Administrasi',
            'staf_keu' => 'Staf Keuangan',
            'staf_per' => 'Staf Perencanaan',
            'staf_pel' => 'Staf Pelayanan',
            'op_desa' => 'Operator Desa',
            'bendahara' => 'Bendahara',
            'arsip' => 'Pengelola Arsip',
            'umum' => 'Staf Umum',
        ];

        $fields = [];

        foreach ($jabatanList as $kode => $label) {
            $fields = array_merge($fields, [
                ['nama' => "nama_{$kode}", 'label' => "Nama {$label}", 'source' => 'profil_desa', 'source_field' => "{$kode}.nama", 'input_mode' => 'auto'],
                ['nama' => "nip_{$kode}", 'label' => "NIP {$label}", 'source' => 'profil_desa', 'source_field' => "{$kode}.nip", 'input_mode' => 'auto'],
                ['nama' => "telepon_{$kode}", 'label' => "Telepon {$label}", 'source' => 'profil_desa', 'source_field' => "{$kode}.telepon", 'input_mode' => 'auto'],
                ['nama' => "email_{$kode}", 'label' => "Email {$label}", 'source' => 'profil_desa', 'source_field' => "{$kode}.email", 'input_mode' => 'auto'],
                // ['nama' => "foto_{$kode}", 'label' => "Foto {$label}", 'source' => 'profil_desa', 'source_field' => "{$kode}.foto", 'input_mode' => 'auto'],
                // ['nama' => "ttd_{$kode}", 'label' => "TTD {$label}", 'source' => 'profil_desa', 'source_field' => "{$kode}.tanda_tangan", 'input_mode' => 'auto'],
                ['nama' => "tgl_mulai_{$kode}", 'label' => "Tgl Mulai {$label}", 'source' => 'profil_desa', 'source_field' => "{$kode}.tanggal_mulai", 'input_mode' => 'auto'],
                // ['nama' => "tgl_selesai_{$kode}", 'label' => "Tgl Selesai {$label}", 'source' => 'profil_desa', 'source_field' => "{$kode}.tanggal_selesai", 'input_mode' => 'auto'],
            ]);
        }


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
