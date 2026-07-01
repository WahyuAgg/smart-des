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
            ['kode' => '3301012001'],
            [
                'provinsi_id' => '2',
                'kabupaten_id' => '2',
                'kecamatan_id' => '2',
                'desa_id' => '2',

                'nama' => 'Curug',
                'kode' => '3301012001',
                'kode_pos' => '51111',

                'alamat' => 'Jl. Raya Desa Curug No. 1',
                'telepon' => '0281123456',
                'email' => 'desa_curug@example.com',
                'website' => 'https://desacurug.id',
                'logo' => null,

                'visi' => 'Terwujudnya desa yang maju, mandiri, sejahtera, dan berdaya saing.',

                'misi' => "- Meningkatkan kualitas pelayanan kepada masyarakat.\n"
                    . "- Mengembangkan potensi ekonomi desa.\n"
                    . "- Meningkatkan kualitas sumber daya manusia.\n"
                    . "- Mewujudkan tata kelola pemerintahan yang transparan dan akuntabel.",

                'deskripsi' => 'Desa Curug merupakan desa fiktif yang digunakan sebagai data awal (seed) pada aplikasi Sistem Pelayanan Surat Desa.',
            ]
        );
    }
}