<?php

namespace Database\Seeders\GeneralSeeder;

use App\Models\InvKategoriBarang;
use Illuminate\Database\Seeder;

class InvKategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriBarang = [
            [
                'nama' => 'Elektronik',
                'keterangan' => 'Barang-barang elektronik seperti komputer, printer, dan peralatan elektronik lainnya',
            ],
            [
                'nama' => 'Furniture',
                'keterangan' => 'Meja, kursi, lemari, dan perabotan kantor desa',
            ],

            [
                'nama' => 'Alat Tulis Kantor',
                'keterangan' => 'Kertas, pulpen, tinta printer, dan perlengkapan tulis menulis',
            ],
            [
                'nama' => 'Peralatan Kebersihan',
                'keterangan' => 'Sapu, pel, pembersih lantai, dan alat kebersihan lainnya',
            ],
            [
                'nama' => 'Alat Pertanian',
                'keterangan' => 'Cangkul, traktor, pompa air, dan peralatan pertanian desa',
            ],
            [
                'nama' => 'Peralatan Olahraga',
                'keterangan' => 'Bola, net, dan perlengkapan olahraga untuk kegiatan desa',
            ],
            [
                'nama' => 'Alat Musik',
                'keterangan' => 'Gamelan, rebana, dan alat musik untuk kegiatan seni budaya desa',
            ],
            [
                'nama' => 'Peralatan Konstruksi',
                'keterangan' => 'Alat-alat untuk pembangunan dan pemeliharaan infrastruktur desa',
            ],
            [
                'nama' => 'Perlengkapan Kesehatan',
                'keterangan' => 'Timbangan, tensimeter, dan peralatan kesehatan untuk posyandu',
            ],
            [
                'nama' => 'Sound System',
                'keterangan' => 'Speaker, microphone, mixer, dan peralatan audio untuk kegiatan desa',
            ],
            [
                'nama' => 'Perlengkapan Rapat',
                'keterangan' => 'Papan tulis, proyektor, layar, dan perlengkapan pertemuan',
            ],
            [
                'nama' => 'Buku dan Dokumen',
                'keterangan' => 'Buku perpustakaan desa, arsip, dan dokumentasi desa',
            ],
            [
                'nama' => 'Perlengkapan Keamanan',
                'keterangan' => 'Handy talky, senter, dan peralatan keamanan lingkungan',
            ],
            [
                'nama' => 'Perlengkapan PKK',
                'keterangan' => 'Peralatan untuk kegiatan PKK seperti alat memasak, perlengkapan PAUD, alat keterampilan, dan perlengkapan posyandu',
            ],
            [
                'nama' => 'Lain-lain',
                'keterangan' => 'Barang inventaris desa yang tidak termasuk kategori di atas',
            ],
        ];

        foreach ($kategoriBarang as $item) {
            InvKategoriBarang::firstOrCreate(
                ['nama' => $item['nama']],
                ['keterangan' => $item['keterangan']]
            );
        }
    }
}
