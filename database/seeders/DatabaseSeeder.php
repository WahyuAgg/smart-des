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
use Database\Seeders\TestingSrtSeeder\RefKecamatanSeeder;
use Database\Seeders\TestingSrtSeeder\RefPerangkatDesaSeeder;
use Database\Seeders\TestingSrtSeeder\SrtJenisSuratPendudukSeeder;


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
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,

            // // REFERENCE SEEDER
            RefJabatanPerangkatSeeder::class,
            PendidikanSeeder::class,

            // // USER SEEDER DAN ROLE SEEDER
            RoleSeeder::class,
            UserSeeder::class,
            AssignRoles::class,

            // // SURAT SEEDER
            KategoriSuratSeeder::class,
            JenisSuratSeeder::class,
            MasterFieldSuratSeeder::class,


            // // CURUG SEEDER
            RefProfilDesaSeeder::class,
            RefDusunSeeder::class,
            RefRwSeeder::class,
            RefRtSeeder::class,
            AlamatSeeder::class,

            // // TESTING SEEDER
            // KkPendudukSeeder::class,
            RefPerangkatDesaSeeder::class,
            RefKecamatanSeeder::class,
            SrtJenisSuratPendudukSeeder::class,


        ]);
    }
}
