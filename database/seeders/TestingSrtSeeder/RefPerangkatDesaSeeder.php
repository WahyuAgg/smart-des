<?php

namespace database\Seeders\TestingSrtSeeder;

use App\Models\RefJabatanPerangkat;
use App\Models\RefPerangkatDesa;
use Illuminate\Database\Seeder;

class RefPerangkatDesaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil semua jabatan perangkat
        $jabatans = RefJabatanPerangkat::all();

        // 2. Siapkan data hardcode (sesuaikan dengan 18 posisi/nama yang Anda inginkan)
$dataPerangkat = [
    ['nama' => 'Budi Santoso', 'nip' => '19800101001', 'telepon' => '081234567890', 'email' => 'kepala@desa.id', 'tanggal_mulai' => '2020-01-01', 'aktif' => true],
    ['nama' => 'Siti Aminah', 'nip' => '19850202002', 'telepon' => '081234567891', 'email' => 'sekdes@desa.id', 'tanggal_mulai' => '2020-02-01', 'aktif' => true],
    ['nama' => 'Ahmad Fauzi', 'nip' => '19820303003', 'telepon' => '081234567892', 'email' => 'kasi_pemerintahan@desa.id', 'tanggal_mulai' => '2020-03-01', 'aktif' => true],
    ['nama' => 'Dewi Lestari', 'nip' => '19880404004', 'telepon' => '081234567893', 'email' => 'kasi_kesra@desa.id', 'tanggal_mulai' => '2020-04-01', 'aktif' => true],
    ['nama' => 'Bambang S.', 'nip' => '19750505005', 'telepon' => '081234567894', 'email' => 'kasi_pelayanan@desa.id', 'tanggal_mulai' => '2020-05-01', 'aktif' => true],
    ['nama' => 'Rina Kurnia', 'nip' => '19900606006', 'telepon' => '081234567895', 'email' => 'kaur_keuangan@desa.id', 'tanggal_mulai' => '2020-06-01', 'aktif' => true],
    ['nama' => 'Hendra Wijaya', 'nip' => '19870707007', 'telepon' => '081234567896', 'email' => 'kaur_umum@desa.id', 'tanggal_mulai' => '2020-07-01', 'aktif' => true],
    ['nama' => 'Siska Putri', 'nip' => '19920808008', 'telepon' => '081234567897', 'email' => 'kaur_perencanaan@desa.id', 'tanggal_mulai' => '2020-08-01', 'aktif' => true],
    ['nama' => 'Agus Priyanto', 'nip' => '19810909009', 'telepon' => '081234567898', 'email' => 'kadus1@desa.id', 'tanggal_mulai' => '2020-09-01', 'aktif' => true],
    ['nama' => 'Dwi Handayani', 'nip' => '19841010010', 'telepon' => '081234567899', 'email' => 'kadus2@desa.id', 'tanggal_mulai' => '2020-10-01', 'aktif' => true],
    ['nama' => 'Eko Prasetyo', 'nip' => '19861111011', 'telepon' => '081234567800', 'email' => 'kadus3@desa.id', 'tanggal_mulai' => '2020-11-01', 'aktif' => true],
    ['nama' => 'Fitriani', 'nip' => '19891212012', 'telepon' => '081234567801', 'email' => 'staf_admin1@desa.id', 'tanggal_mulai' => '2021-01-15', 'aktif' => true],
    ['nama' => 'Guntur Jaya', 'nip' => '19910113013', 'telepon' => '081234567802', 'email' => 'staf_admin2@desa.id', 'tanggal_mulai' => '2021-02-15', 'aktif' => true],
    ['nama' => 'Hasan Basri', 'nip' => '19780214014', 'telepon' => '081234567803', 'email' => 'staf_keamanan@desa.id', 'tanggal_mulai' => '2021-03-15', 'aktif' => true],
    ['nama' => 'Indah Sari', 'nip' => '19930315015', 'telepon' => '081234567804', 'email' => 'staf_kebersihan@desa.id', 'tanggal_mulai' => '2021-04-15', 'aktif' => true],
    ['nama' => 'Joko Widodo', 'nip' => '19900303003', 'telepon' => '081234567805', 'email' => 'staf_IT@desa.id', 'tanggal_mulai' => '2021-05-15', 'aktif' => true],
    ['nama' => 'Kartika Dewi', 'nip' => '19850417017', 'telepon' => '081234567806', 'email' => 'staf_operasional@desa.id', 'tanggal_mulai' => '2021-06-15', 'aktif' => true],
    ['nama' => 'Lutfi Hakim', 'nip' => '19830518018', 'telepon' => '081234567807', 'email' => 'camat@desa.id', 'tanggal_mulai' => '2021-07-15', 'aktif' => true],
];

        // 3. Iterasi jabatan dan pasangkan dengan data perangkat
foreach ($jabatans as $index => $jabatan) {
    if (! isset($dataPerangkat[$index])) {
        continue;
    }

    $data = $dataPerangkat[$index];

    try {
        RefPerangkatDesa::create([
            'jabatan_perangkat_id' => $jabatan->id,
            'nama'                 => $data['nama'],
            'nip'                  => $data['nip'],
            'telepon'              => $data['telepon'],
            'email'                => $data['email'],
            'tanggal_mulai'        => $data['tanggal_mulai'],
            'aktif'                => $data['aktif'],
        ]);
    } catch (\Throwable $e) {
        continue;
    }
}
    }
}