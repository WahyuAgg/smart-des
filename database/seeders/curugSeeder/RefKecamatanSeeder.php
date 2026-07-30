<?php

namespace Database\Seeders\CurugSeeder;

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
                'camat' => 'Drs. Bambang Suryono',
                'nip' => '196804121990031001',
                'telepon' => '0287-123456',
                'email' => 'kecamatan.ngombol@example.go.id',
            ],
        ];

        foreach ($data as $item) {
            RefKecamatan::create($item);
        }
    }
}