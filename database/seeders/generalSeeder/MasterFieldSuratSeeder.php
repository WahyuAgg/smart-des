<?php

namespace Database\Seeders\GeneralSeeder;

use App\Models\SrtMasterFieldSurat;
use Illuminate\Database\Seeder;
use Database\Seeders\generalSeeder\MasterFieldSurat\AlamatPendudukSeeder;
use Database\Seeders\generalSeeder\MasterFieldSurat\ManualFieldSeeder;
use Database\Seeders\generalSeeder\MasterFieldSurat\PerangkatDesaSeeder;
use Database\Seeders\generalSeeder\MasterFieldSurat\DataPendudukSeeder;
use Database\Seeders\GeneralSeeder\MasterFieldSurat\ProfilDesaSeeder;
use Database\Seeders\GeneralSeeder\MasterFieldSurat\SystemSupportSeeder;



class MasterFieldSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AlamatPendudukSeeder::class,
            ManualFieldSeeder::class,
            PerangkatDesaSeeder::class,
            DataPendudukSeeder::class,
            ProfilDesaSeeder::class,
            SystemSupportSeeder::class
        ]);
    }
}