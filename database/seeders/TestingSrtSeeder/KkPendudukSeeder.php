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
        $pekerjaan = Pekerjaan::query()->first();

        // Data Hardcode untuk 5 KK
        $dataKk = [
            ['no_kk' => '1111111111111111', 'nik_kepala_keluarga' => '1000000000000001'],
            ['no_kk' => '2222222222222222', 'nik_kepala_keluarga' => '1000000000000002'],
            ['no_kk' => '3333333333333333', 'nik_kepala_keluarga' => '1000000000000003'],
            ['no_kk' => '4444444444444444', 'nik_kepala_keluarga' => '1000000000000004'],
            ['no_kk' => '5555555555555555', 'nik_kepala_keluarga' => '1000000000000005'],
        ];

        // Data Hardcode untuk 10 Penduduk
        $dataPenduduk = [
            ['nik' => '9000000000000001', 'nama_lengkap' => 'Budi Santoso', 'kk_index' => 0],
            ['nik' => '9000000000000002', 'nama_lengkap' => 'Siti Aminah', 'kk_index' => 0],
            ['nik' => '9000000000000003', 'nama_lengkap' => 'Agus Wijaya', 'kk_index' => 1],
            ['nik' => '9000000000000004', 'nama_lengkap' => 'Dewi Lestari', 'kk_index' => 1],
            ['nik' => '9000000000000005', 'nama_lengkap' => 'Eko Prasetyo', 'kk_index' => 2],
            ['nik' => '9000000000000006', 'nama_lengkap' => 'Rina Marlina', 'kk_index' => 2],
            ['nik' => '9000000000000007', 'nama_lengkap' => 'Fajar Sidik', 'kk_index' => 3],
            ['nik' => '9000000000000008', 'nama_lengkap' => 'Putri Indah', 'kk_index' => 3],
            ['nik' => '9000000000000009', 'nama_lengkap' => 'Hendra Gunawan', 'kk_index' => 4],
            ['nik' => '9000000000000010', 'nama_lengkap' => 'Siska Amelia', 'kk_index' => 4],
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
                'kewarganegaraan'    => 'WNI',
                'golongan_darah'     => 'O',
                'no_hp'              => '081234567890',
                'email'              => 'penduduk' . $pData['nik'] . '@example.com',
                'tanggal_meninggal'  => null,
                'kk_id' => $listKkId[$pData['kk_index']],
                'alamat_id' => $alamat->id ?? null,
                'pendidikan_id' => $pendidikan->id ?? null,
                'pekerjaan_id' => $pekerjaan->id ?? null,
            ]);
        }
    }
}
