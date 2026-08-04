<?php

namespace Database\Seeders\generalSeeder;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@desa.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        )->assignRole('admin');

        User::updateOrCreate(
            ['email' => 'petugas@desa.id'],
            [
                'name' => 'Petugas',
                'password' => Hash::make('password'),
            ]
        )->assignRole('petugas');

        User::updateOrCreate(
            ['email' => 'kades@desa.id'],
            [
                'name' => 'Kepala Desa',
                'password' => Hash::make('password'),
            ]
        )->assignRole('kepala_desa');
    }
}
