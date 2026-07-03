<?php

namespace Database\Seeders\GeneralSeeder;

use App\Models\SrtMasterFieldSurat;
use Illuminate\Database\Seeder;

class MasterFieldSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            // DATA PENDUDUK
            ['nama' => 'nama_lengkap', 'label' => 'Nama Lengkap', 'source' => 'penduduk', 'source_field' => 'nama_lengkap', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'nama', 'label' => 'Nama', 'source' => 'penduduk', 'source_field' => 'nama_lengkap', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'nik', 'label' => 'NIK', 'source' => 'penduduk', 'source_field' => 'nik', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'no_kk', 'label' => 'Nomor KK', 'source' => 'penduduk', 'source_field' => 'no_kk', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'source' => 'penduduk', 'source_field' => 'tempat_lahir', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'source' => 'penduduk', 'source_field' => 'tanggal_lahir', 'tipe' => 'date', 'input_mode' => 'auto'],
            ['nama' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'source' => 'penduduk', 'source_field' => 'jenis_kelamin', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'agama', 'label' => 'Agama', 'source' => 'penduduk', 'source_field' => 'agama', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'status_perkawinan', 'label' => 'Status Perkawinan', 'source' => 'penduduk', 'source_field' => 'status_perkawinan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'pekerjaan', 'label' => 'Pekerjaan', 'source' => 'penduduk', 'source_field' => 'nama_pekerjaan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'kewarganegaraan', 'label' => 'Kewarganegaraan', 'source' => 'penduduk', 'source_field' => 'kewarganegaraan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat', 'label' => 'Alamat', 'source' => 'penduduk', 'source_field' => 'alamat_lengkap', 'tipe' => 'textarea', 'input_mode' => 'auto'],
            ['nama' => 'alamat_provinsi', 'label' => 'Alamat Provinsi', 'source' => 'penduduk', 'source_field' => 'alamat_provinsi', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_kabupaten', 'label' => 'Alamat Kabupaten', 'source' => 'penduduk', 'source_field' => 'kabupaten', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_kecamatan', 'label' => 'Alamat Kecamatan', 'source' => 'penduduk', 'source_field' => 'kecamatan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_desa', 'label' => 'Alamat Desa', 'source' => 'penduduk', 'source_field' => 'desa', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_jalan', 'label' => 'Alamat Jalan', 'source' => 'penduduk', 'source_field' => 'jalan', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_rt_rw', 'label' => 'Alamat RT/RW', 'source' => 'penduduk', 'source_field' => 'rt_rw', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'rt', 'label' => 'RT', 'source' => 'penduduk', 'source_field' => 'rt', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'rw', 'label' => 'RW', 'source' => 'penduduk', 'source_field' => 'rw', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'dusun', 'label' => 'Dusun', 'source' => 'penduduk', 'source_field' => 'dusun', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'kode_pos', 'label' => 'Kode Pos', 'source' => 'penduduk', 'source_field' => 'kode_pos', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'nomor_hp', 'label' => 'Nomor HP', 'source' => 'penduduk', 'source_field' => 'nomor_hp', 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'email', 'label' => 'Email', 'source' => 'penduduk', 'source_field' => 'email', 'tipe' => 'email', 'input_mode' => 'auto'],
            ['nama' => 'tanggal_tercatat', 'label' => 'Tanggal Tercatat', 'source' => 'penduduk', 'source_field' => 'tanggal_lahir', 'tipe' => 'date', 'input_mode' => 'auto'],

            // PROFIL DESA
            ['nama' => 'nama_desa', 'label' => 'Nama Desa', 'source' => 'profil_desa', 'source_field' => 'nama', 'input_mode' => 'auto'],
            ['nama' => 'alamat_kantor', 'label' => 'Alamat Kantor', 'source' => 'profil_desa', 'source_field' => 'alamat', 'input_mode' => 'auto'],
            ['nama' => 'kode_pos_desa', 'label' => 'Kode Pos Desa', 'source' => 'profil_desa', 'source_field' => 'kode_pos', 'input_mode' => 'auto'],
            ['nama' => 'telepon_desa', 'label' => 'Telepon Desa', 'source' => 'profil_desa', 'source_field' => 'telepon', 'input_mode' => 'auto'],
            ['nama' => 'email_desa', 'label' => 'Email Desa', 'source' => 'profil_desa', 'source_field' => 'email', 'input_mode' => 'auto'],
            ['nama' => 'website_desa', 'label' => 'Website Desa', 'source' => 'profil_desa', 'source_field' => 'website', 'input_mode' => 'auto'],
            ['nama' => 'kecamatan', 'label' => 'Kecamatan', 'source' => 'profil_desa', 'source_field' => 'kecamatan', 'input_mode' => 'auto'],
            ['nama' => 'kabupaten', 'label' => 'Kabupaten', 'source' => 'profil_desa', 'source_field' => 'kabupaten', 'input_mode' => 'auto'],
            ['nama' => 'provinsi', 'label' => 'Provinsi', 'source' => 'profil_desa', 'source_field' => 'provinsi', 'input_mode' => 'auto'],

            // PERANGKAT DESA
            ['nama' => 'nama_penandatangan', 'label' => 'Nama Penandatangan', 'source' => 'perangkat', 'source_field' => 'nama', 'input_mode' => 'auto'],
            ['nama' => 'jabatan_penandatangan', 'label' => 'Jabatan Penandatangan', 'source' => 'perangkat', 'source_field' => 'jabatan', 'input_mode' => 'auto'],

            // JENIS SURAT
            ['nama' => 'nama_jenis_surat', 'label' => 'Nama Jenis Surat', 'source' => 'jenis_surat', 'source_field' => 'nama_jenis_surat', 'input_mode' => 'auto'],

            // SISTEM
            ['nama' => 'nomor_surat', 'label' => 'Nomor Surat', 'source' => 'system', 'source_field' => 'nomor_surat', 'input_mode' => 'auto'],
            ['nama' => 'tanggal_surat', 'label' => 'Tanggal Surat', 'source' => 'system', 'source_field' => 'tanggal_surat', 'input_mode' => 'auto'],
            ['nama' => 'tanggal_cetak', 'label' => 'Tanggal Cetak', 'source' => 'system', 'source_field' => 'tanggal_cetak', 'input_mode' => 'auto'],
            ['nama' => 'tahun', 'label' => 'Tahun', 'source' => 'system', 'source_field' => 'tahun', 'input_mode' => 'auto'],
            ['nama' => 'bulan', 'label' => 'Bulan', 'source' => 'system', 'source_field' => 'bulan', 'input_mode' => 'auto'],
            ['nama' => 'hari', 'label' => 'Hari', 'source' => 'system', 'source_field' => 'hari', 'input_mode' => 'auto'],

            // INPUT ADMIN / PEMOHON
            ['nama' => 'keperluan', 'label' => 'Keperluan', 'source' => 'input', 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'auto'],
            ['nama' => 'tujuan', 'label' => 'Tujuan', 'source' => 'input', 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'keterangan', 'label' => 'Keterangan', 'source' => 'input', 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'auto'],
            ['nama' => 'catatan', 'label' => 'Catatan', 'source' => 'input', 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'auto'],
            ['nama' => 'nama_usaha', 'label' => 'Nama Usaha', 'source' => 'input', 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'jenis_usaha', 'label' => 'Jenis Usaha', 'source' => 'input', 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'alamat_usaha', 'label' => 'Alamat Usaha', 'source' => 'input', 'source_field' => null, 'tipe' => 'textarea', 'input_mode' => 'auto'],
            ['nama' => 'luas_tanah', 'label' => 'Luas Tanah', 'source' => 'input', 'source_field' => null, 'tipe' => 'number', 'input_mode' => 'auto'],
            ['nama' => 'nomor_sertifikat', 'label' => 'Nomor Sertifikat', 'source' => 'input', 'source_field' => null, 'tipe' => 'text', 'input_mode' => 'auto'],
            ['nama' => 'lama_usaha', 'label' => 'Lama Usaha', 'source' => 'input', 'source_field' => null, 'tipe' => 'number', 'input_mode' => 'auto'],
            ['nama' => 'penghasilan', 'label' => 'Penghasilan', 'source' => 'input', 'source_field' => null, 'tipe' => 'currency', 'input_mode' => 'auto'],
        ];

        foreach ($fields as $field) {

            SrtMasterFieldSurat::updateOrCreate(
                [
                    'nama' => $field['nama'],
                ],
                [
                    'label'         => $field['label'],
                    'source'        => $field['source'],
                    'source_field'  => $field['source_field'],
                    'tipe'          => $field['tipe'] ?? 'text',
                    'opsi'          => $field['opsi'] ?? null,
                    'placeholder'   => $field['placeholder'] ?? null,
                    'keterangan'    => $field['keterangan'] ?? null,
                ]
            );
        }
    }
}
