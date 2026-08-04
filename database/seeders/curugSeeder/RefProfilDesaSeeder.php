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

                'nama' => 'Curug',
                'kode' => '3306022050',
                'kode_pos' => null,

                'alamat' => 'Jln.Lingkar Utara, Desa Curug, RT 002, RW 001, Kecamatan Ngombol, Kabupaten Purworejo, Jawa Tengah.',
                'telepon' => '081234567890',
                'email' => 'desa_curug@example.com',
                'website' => 'https://desacurug.co.id',
                'logo' => null,

                'visi' => 'Mewujudkan Desa Curug yang Mandiri, Sejahtera, Berbudaya, dan Berbasis Ekowisata Digital di Tahun 2031',

                'misi' => [
                    'Meningkatkan kualitas sumber daya manusia melalui pendidikan dan pelatihan.',
                    'Meningkatkan produktivitas sektor pertanian, khususnya pertanian padi, melalui penerapan teknologi, pengelolaan lahan yang berkelanjutan, dan peningkatan kualitas sumber daya petani.',
                    'Digitalisasi Pelayanan: Menyelenggarakan layanan publik berbasis aplikasi untuk mempermudah warga.',
                    'Mendorong pemberdayaan masyarakat melalui peningkatan keterampilan, pengembangan usaha mikro, serta penguatan kelembagaan desa',
                    'Mewujudkan tata kelola pemerintahan desa yang partisipatif, transparan, dan berorientasi pada pelayanan masyarakat.',
                ],

                'deskripsi' => 'Desa Curug merupakan desa agraris yang terletak di Kecamatan Ngombol, Kabupaten Purworejo, Provinsi Jawa Tengah.',
            ]
        );
    }
}
