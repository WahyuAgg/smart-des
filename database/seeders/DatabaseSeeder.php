<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\GeneralSeeder\RoleSeeder;
use Database\Seeders\GeneralSeeder\UserSeeder;
use Database\Seeders\GeneralSeeder\AssignRoles;

use Laravolt\Indonesia\Seeds\ProvincesSeeder;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;

use Database\Seeders\GeneralSeeder\RefJabatanPerangkatSeeder;
use Database\Seeders\GeneralSeeder\PendidikanSeeder;
use Database\Seeders\GeneralSeeder\KategoriSuratSeeder;
use Database\Seeders\GeneralSeeder\MasterFieldSuratSeeder;


use Database\Seeders\curugSeeder\RefProfilDesaSeeder;
use Database\Seeders\curugSeeder\RefDusunSeeder;
use Database\Seeders\curugSeeder\RefRwSeeder;
use Database\Seeders\curugSeeder\RefRtSeeder;

use Database\Seeders\CurugSeeder\RefKecamatanSeeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            // // LARAVOLT INDONESIA SEEDER
            // ProvincesSeeder::class,
            // CitiesSeeder::class,
            // DistrictsSeeder::class,
            // VillagesSeeder::class,

            // // REFERENCE SEEDER
            // RefJabatanPerangkatSeeder::class,
            // PendidikanSeeder::class,

            // // // USER SEEDER DAN ROLE SEEDER
            // RoleSeeder::class,
            // UserSeeder::class,
            // AssignRoles::class,

            // // // SURAT SEEDER
            // KategoriSuratSeeder::class,
            MasterFieldSuratSeeder::class,


            // // // CURUG SEEDER
            // RefProfilDesaSeeder::class,
            // RefDusunSeeder::class,
            // RefRwSeeder::class,
            // RefRtSeeder::class,
            // RefKecamatanSeeder::class,


            // // TESTING SEEDER


        ]);
    }
}
