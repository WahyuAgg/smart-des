<?php

namespace Database\Factories;

use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Penduduk>
 */
class PendudukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // database/factories/PendudukFactory.php
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->numerify('################'),
            'nama_lengkap' => $this->faker->name,
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tanggal_lahir' => $this->faker->date,
            'tempat_lahir' => $this->faker->city,
            'agama' => 'Islam',
            'status_perkawinan' => 'Kawin',
            'kewarganegaraan' => 'WNI',
            'golongan_darah' => 'O',
            'no_hp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'status_hidup' => 'Hidup',
        ];
    }
}
