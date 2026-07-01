<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Laravolt\Indonesia\Seeds\ProvincesSeeder;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;

use Database\Seeders\GeneralSeeder\PekerjaanSeeder;
use Database\Seeders\GeneralSeeder\RefJabatanPerangkatSeeder;
use Database\Seeders\GeneralSeeder\PendidikanSeeder;
use Database\Seeders\GeneralSeeder\KategoriSuratSeeder;
use Database\Seeders\GeneralSeeder\JenisSuratSeeder;

use Database\Seeders\curugSeeder\RefProfilDesaSeeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // UserSeeder::class,


            // ProvincesSeeder::class,
            // CitiesSeeder::class,
            // DistrictsSeeder::class,
            // VillagesSeeder::class,


            PekerjaanSeeder::class,
            RefJabatanPerangkatSeeder::class,
            PendidikanSeeder::class,
            // AlamatSeeder::class,
            // KkSeeder::class,
            // PendidikanSeeder::class,


            KategoriSuratSeeder::class,
            JenisSuratSeeder::class,

            RefProfilDesaSeeder::class,
        ]);

    }

}
