<?php

namespace Database\Seeders\TestingSrtSeeder;

use App\Models\Kk;
use App\Models\Penduduk;
use App\Models\Alamat;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use Illuminate\Database\Seeder;

class KkPendudukSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data referensi pertama
        $alamat = Alamat::query()->first();
        $pendidikan = Pendidikan::query()->first();

        // Data Hardcode untuk 5 KK
        $dataKk = [
            ['no_kk' => '1111111111111111', 'nik_kepala_keluarga' => '1000000000000001'],
        ];

        // Data Hardcode untuk 10 Penduduk
        $dataPenduduk = [
            ['nik' => '9000000000000001', 'nama_lengkap' => 'Budi Santoso', 'kk_index' => 0],
        ];

        // Buat KK dan simpan ID-nya ke array
        $listKkId = [];
        foreach ($dataKk as $kkData) {
            $kk = Kk::create($kkData);
            $listKkId[] = $kk->id;
        }

        // Buat Penduduk dan hubungkan ke KK berdasarkan index
        foreach ($dataPenduduk as $pData) {
            Penduduk::create([
                'nik' => $pData['nik'],
                'nama_lengkap' => $pData['nama_lengkap'],
                'jenis_kelamin' => 'Laki-laki', // Default hardcode
                'tanggal_lahir' => '1990-01-01', // Default hardcode
                'status_hidup' => 'Hidup',      // Default hardcode
                'tempat_lahir'       => 'Jakarta',
                'agama'              => 'Islam',
                'status_perkawinan'  => 'Belum Kawin',
                'kewarganegaraan'    => 'INDONESIA',
                'golongan_darah'     => 'O',
                'no_hp'              => '081234567890',
                'email'              => 'penduduk' . $pData['nik'] . '@example.com',
                'tanggal_meninggal'  => null,
                'kk_id' => $listKkId[$pData['kk_index']],
                'alamat_id' => $alamat->id ?? null,
                'pendidikan_id' => $pendidikan->id ?? null,
                'pekerjaan' => 'Petani/Nelayan',
            ]);
        }
    }
}
