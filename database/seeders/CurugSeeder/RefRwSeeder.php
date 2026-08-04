<?php

namespace Database\Seeders\CurugSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RefDusun;
use App\Models\RefRw;

class RefRwSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        $dusun = RefDusun::query()->where('nama', 'Curug')->first();
        $dusunId = $dusun ? $dusun->id : null;

        RefRw::firstOrCreate([
            'nomor_rw' => '001',
            'ketua_rw' => 'Nama Ketua RW 001',
            'dusun_id' => $dusunId,
        ]);
    }
}