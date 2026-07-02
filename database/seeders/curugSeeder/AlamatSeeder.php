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
            ['alamat_lengkap' => 'Jln.Lingkar Utara Desa Curug, Rt/Rw 002/001, Kecamatan Ngombol, Kabupaten Purworejo, Jawa Tengah.'],
            [
                'jalan' => 'Jln.Lingkar Utara',
                'rt' => '002',
                'rw' => '001',
                'desa' => 'Curug',
                'kecamatan' => 'Ngombol',
                'kabupaten' => 'Purworejo',
                'provinsi' => 'Jawa Tengah',
                'kode_pos' => '56281',
                'latitude' => -7.783981,
                'longitude' => 109.961424,
            ]
        );
    }
}
