<?php

namespace Database\Seeders\curugSeeder;

use App\Models\RefProfilDesa;
use Illuminate\Database\Seeder;

class RefProfilDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RefProfilDesa::updateOrCreate(
            ['kode' => '3306022050'],
            [
                'provinsi_code' => '33',
                'kabupaten_code' => '3306',
                'kecamatan_code' => '330602',
                'desa_code' => '3306022050',

                'nama' => 'Curug',
                'kode' => '3306022050',
                'kode_pos' => '111111',

                'alamat' => 'Jln.Lingkar Utara Desa Curug, Rt/Rw 002/001, Kecamatan Ngombol, Kabupaten Purworejo, Jawa Tengah.',
                'telepon' => '081234567890',
                'email' => 'desa_curug@example.com',
                'website' => 'https://desacurug.co.id',
                'logo' => null,

                'visi' => '-',

                'misi' => "-",

                'deskripsi' => 'Desa Curug merupakan desa fiktif yang digunakan sebagai data awal (seed) pada aplikasi Sistem Pelayanan Surat Desa.',
            ]
        );
    }
}