<?php

namespace Database\Seeders\TestingSrtSeeder;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SrtJenisSuratPenduduk;

class SrtJenisSuratPendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SrtJenisSuratPenduduk::create([
            'jenis_surat_id' => 1,
            'urutan' => 1,
            'kode' => 'pelapor',
            'label' => 'Pelapor',
            'deskripsi' => 'Masukkan NIK penduduk yang melaporkan',
            'wajib' => true,
        ]);

        SrtJenisSuratPenduduk::create([
            'jenis_surat_id' => 1,
            'urutan' => 2,
            'kode' => 'meninggal',
            'label' => 'Meninggal',
            'deskripsi' => 'Masukkan NIK penduduk yang meninggal',
            'wajib' => true,
        ]);
    }
}
