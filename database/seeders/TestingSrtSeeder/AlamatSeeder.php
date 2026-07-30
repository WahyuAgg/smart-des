<?php

namespace Database\Seeders\CurugSeeder;

use App\Models\Alamat;
use Illuminate\Database\Seeder;

class AlamatSeeder extends Seeder
{
    /**
     * Helper for create alamat when importing penduduk from excel file. This is to ensure that the alamat data is consistent with the penduduk data.
     */
    public function run(): void
    {
        Alamat::updateOrCreate(
            ['alamat_lengkap' => 'Desa Curug, RT 001 RW 002, Kecamatan Ngombol, Kabupaten Purworejo, Jawa Tengah.'],
            [
                'jalan' => 'Jln.Lingkar Utara',
                'rt' => '', // disamakan dengan data excel
                'rw' => '', // disamakan dengan data excel
                'desa' => 'Curug',
                'kecamatan' => 'Ngombol',
                'kabupaten' => 'Purworejo',
                'provinsi' => 'Jawa Tengah',
                'kode_pos' => '54172',
                'latitude' => -7.783981,
                'longitude' => 109.961424,
            ]
        );
    }
}
