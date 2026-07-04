<?php

namespace Database\Seeders\CurugSeeder;

use App\Models\Alamat;
use Illuminate\Database\Seeder;

class AlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
