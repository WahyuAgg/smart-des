<?php

namespace Database\Seeders\GeneralSeeder;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AssignRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@desa.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
            ]
        );

        $admin->syncRoles('admin');

        $petugas = User::updateOrCreate(
            ['email' => 'petugas@desa.id'],
            [
                'name' => 'Petugas',
                'password' => Hash::make('petugas123'),
            ]
        );

        $petugas->syncRoles('petugas');

        $kades = User::updateOrCreate(
            ['email' => 'kades@desa.id'],
            [
                'name' => 'Kepala Desa',
                'password' => Hash::make('kades123'),
            ]
        );

        $kades->syncRoles('kepala_desa');
    }
}
