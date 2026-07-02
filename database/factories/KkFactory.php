<?php

namespace Database\Factories;

use App\Models\Kk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kk>
 */
class KkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // database/factories/KkFactory.php
    public function definition(): array
    {
        return [
            'no_kk' => $this->faker->unique()->numerify('################'),
            'nik_kepala_keluarga' => $this->faker->unique()->numerify('################'),
        ];
    }
}
