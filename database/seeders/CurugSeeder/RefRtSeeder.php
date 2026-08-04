<?php

namespace Database\Seeders\CurugSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RefRt;
use App\Models\RefRw;

class RefRtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rw1 = RefRw::query()->where('nomor_rw', '001')->first();
        $rw1Id = $rw1 ? $rw1->id : null;

        RefRt::firstOrCreate([
            'nomor_rt' => '001',
            'ketua_rt' => 'Nama Ketua RT 001',
            'rw_id' => $rw1Id,
        ]);

        RefRt::firstOrCreate([
            'nomor_rt' => '002',
            'ketua_rt' => 'Nama Ketua RT 002',
            'rw_id' => $rw1Id,
        ]);
    }
}