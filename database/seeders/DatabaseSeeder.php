<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\GeneralSeeder\RoleSeeder;
use Database\Seeders\GeneralSeeder\UserSeeder;
use Database\Seeders\GeneralSeeder\AssignRoles;

use Laravolt\Indonesia\Seeds\ProvincesSeeder;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;

use Database\Seeders\GeneralSeeder\PekerjaanSeeder;
use Database\Seeders\GeneralSeeder\RefJabatanPerangkatSeeder;
use Database\Seeders\GeneralSeeder\PendidikanSeeder;
use Database\Seeders\GeneralSeeder\KategoriSuratSeeder;
use Database\Seeders\GeneralSeeder\JenisSuratSeeder;
use Database\Seeders\GeneralSeeder\MasterFieldSuratSeeder;


use Database\Seeders\curugSeeder\RefProfilDesaSeeder;
use Database\Seeders\curugSeeder\RefDusunSeeder;
use Database\Seeders\curugSeeder\RefRwSeeder;
use Database\Seeders\curugSeeder\RefRtSeeder;
use Database\Seeders\curugSeeder\AlamatSeeder;

use Database\Seeders\TestingSrtSeeder\KkPendudukSeeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            // LARAVOLT INDONESIA SEEDER
            // ProvincesSeeder::class,
            // CitiesSeeder::class,
            // DistrictsSeeder::class,
            // VillagesSeeder::class,

            // REFERENCE SEEDER
            PekerjaanSeeder::class,
            RefJabatanPerangkatSeeder::class,
            PendidikanSeeder::class,

            //USER SEEDER DAN ROLE SEEDER
            RoleSeeder::class,
            UserSeeder::class,
            AssignRoles::class,

            // SURAT SEEDER
            MasterFieldSuratSeeder::class,
            KategoriSuratSeeder::class,
            JenisSuratSeeder::class,


            
            // CURUG SEEDER
            RefProfilDesaSeeder::class,
            RefDusunSeeder::class,
            RefRwSeeder::class,
            RefRtSeeder::class,
            AlamatSeeder::class,

            //TESTING SEEDER
            KkPendudukSeeder::class,
        ]);

    }

}
