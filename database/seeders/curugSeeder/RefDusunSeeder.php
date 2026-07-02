<?php

namespace Database\Seeders\CurugSeeder;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RefDusun;

class RefDusunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RefDusun::firstOrCreate([
            'nama' => 'Curug',
            'kepala_dusun' => 'Budi Santoso',
        ]);
    }
}
