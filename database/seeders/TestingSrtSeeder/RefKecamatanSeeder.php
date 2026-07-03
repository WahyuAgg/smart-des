<?php

namespace Database\Seeders\TestingSrtSeeder;

use App\Models\RefKecamatan;
use Illuminate\Database\Seeder;

class RefKecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Ngombol',
                'nama_pejabat' => 'Drs. Bambang Suryono',
                'nip' => '196804121990031001',
                'telepon' => '0287-123456',
                'email' => 'kecamatan.ngombol@example.go.id',
                'foto' => 'kecamatan/camat.png',
                'tanda_tangan' => 'kecamatan/camat_ttd.png',
            ],
        ];

        foreach ($data as $item) {
            RefKecamatan::create($item);
        }
    }
}