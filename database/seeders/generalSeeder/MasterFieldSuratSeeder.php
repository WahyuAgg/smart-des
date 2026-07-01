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

            // =====================================================
            // DATA PENDUDUK
            // =====================================================

            ['nama' => 'nama_lengkap',          'label' => 'Nama Lengkap',             'source' => 'penduduk', 'source_field' => 'nama',                   'tipe' => 'text'],
            ['nama' => 'nik',                   'label' => 'NIK',                      'source' => 'penduduk', 'source_field' => 'nik',                    'tipe' => 'text'],
            ['nama' => 'no_kk',                 'label' => 'Nomor KK',                'source' => 'penduduk', 'source_field' => 'no_kk',                  'tipe' => 'text'],
            ['nama' => 'tempat_lahir',          'label' => 'Tempat Lahir',            'source' => 'penduduk', 'source_field' => 'tempat_lahir',          'tipe' => 'text'],
            ['nama' => 'tanggal_lahir',         'label' => 'Tanggal Lahir',           'source' => 'penduduk', 'source_field' => 'tanggal_lahir',         'tipe' => 'date'],
            ['nama' => 'jenis_kelamin',         'label' => 'Jenis Kelamin',           'source' => 'penduduk', 'source_field' => 'jenis_kelamin',         'tipe' => 'text'],
            ['nama' => 'agama',                 'label' => 'Agama',                   'source' => 'penduduk', 'source_field' => 'agama',                  'tipe' => 'text'],
            ['nama' => 'status_perkawinan',     'label' => 'Status Perkawinan',       'source' => 'penduduk', 'source_field' => 'status_perkawinan',     'tipe' => 'text'],
            ['nama' => 'pekerjaan',             'label' => 'Pekerjaan',               'source' => 'penduduk', 'source_field' => 'pekerjaan',              'tipe' => 'text'],
            ['nama' => 'kewarganegaraan',       'label' => 'Kewarganegaraan',         'source' => 'penduduk', 'source_field' => 'kewarganegaraan',       'tipe' => 'text'],
            ['nama' => 'alamat',                'label' => 'Alamat',                  'source' => 'penduduk', 'source_field' => 'alamat',                 'tipe' => 'textarea'],
            ['nama' => 'rt',                    'label' => 'RT',                      'source' => 'penduduk', 'source_field' => 'rt',                     'tipe' => 'text'],
            ['nama' => 'rw',                    'label' => 'RW',                      'source' => 'penduduk', 'source_field' => 'rw',                     'tipe' => 'text'],
            ['nama' => 'dusun',                 'label' => 'Dusun',                   'source' => 'penduduk', 'source_field' => 'dusun',                  'tipe' => 'text'],
            ['nama' => 'kode_pos',              'label' => 'Kode Pos',                'source' => 'penduduk', 'source_field' => 'kode_pos',               'tipe' => 'text'],
            ['nama' => 'nomor_hp',              'label' => 'Nomor HP',                'source' => 'penduduk', 'source_field' => 'nomor_hp',               'tipe' => 'text'],
            ['nama' => 'email',                 'label' => 'Email',                   'source' => 'penduduk', 'source_field' => 'email',                  'tipe' => 'email'],

            // =====================================================
            // PROFIL DESA
            // =====================================================

            ['nama' => 'nama_desa',            'label' => 'Nama Desa',                'source' => 'profil_desa', 'source_field' => 'nama'],
            ['nama' => 'alamat_kantor',        'label' => 'Alamat Kantor',            'source' => 'profil_desa', 'source_field' => 'alamat'],
            ['nama' => 'kode_pos_desa',        'label' => 'Kode Pos Desa',            'source' => 'profil_desa', 'source_field' => 'kode_pos'],
            ['nama' => 'telepon_desa',         'label' => 'Telepon Desa',             'source' => 'profil_desa', 'source_field' => 'telepon'],
            ['nama' => 'email_desa',           'label' => 'Email Desa',               'source' => 'profil_desa', 'source_field' => 'email'],
            ['nama' => 'website_desa',         'label' => 'Website Desa',             'source' => 'profil_desa', 'source_field' => 'website'],
            ['nama' => 'kecamatan',            'label' => 'Kecamatan',                'source' => 'profil_desa', 'source_field' => 'kecamatan'],
            ['nama' => 'kabupaten',            'label' => 'Kabupaten',                'source' => 'profil_desa', 'source_field' => 'kabupaten'],
            ['nama' => 'provinsi',             'label' => 'Provinsi',                 'source' => 'profil_desa', 'source_field' => 'provinsi'],

            // =====================================================
            // PERANGKAT DESA
            // =====================================================

            ['nama' => 'nama_penandatangan',      'label' => 'Nama Penandatangan',      'source' => 'perangkat', 'source_field' => 'nama'],
            ['nama' => 'jabatan_penandatangan',   'label' => 'Jabatan Penandatangan',   'source' => 'perangkat', 'source_field' => 'jabatan'],

            // =====================================================
            // JENIS SURAT
            // =====================================================

            ['nama' => 'nama_jenis_surat',     'label' => 'Nama Jenis Surat',         'source' => 'jenis_surat', 'source_field' => 'nama_jenis_surat'],

            // =====================================================
            // SISTEM
            // =====================================================

            ['nama' => 'nomor_surat',          'label' => 'Nomor Surat',              'source' => 'system', 'source_field' => 'nomor_surat'],
            ['nama' => 'tanggal_surat',        'label' => 'Tanggal Surat',            'source' => 'system', 'source_field' => 'tanggal_surat'],
            ['nama' => 'tanggal_cetak',        'label' => 'Tanggal Cetak',            'source' => 'system', 'source_field' => 'tanggal_cetak'],
            ['nama' => 'tahun',                'label' => 'Tahun',                    'source' => 'system', 'source_field' => 'tahun'],
            ['nama' => 'bulan',                'label' => 'Bulan',                    'source' => 'system', 'source_field' => 'bulan'],
            ['nama' => 'hari',                 'label' => 'Hari',                     'source' => 'system', 'source_field' => 'hari'],

            // =====================================================
            // INPUT ADMIN / PEMOHON
            // =====================================================

            ['nama' => 'keperluan',            'label' => 'Keperluan',                'source' => 'input', 'source_field' => null, 'tipe' => 'textarea'],
            ['nama' => 'tujuan',               'label' => 'Tujuan',                   'source' => 'input', 'source_field' => null, 'tipe' => 'text'],
            ['nama' => 'keterangan',           'label' => 'Keterangan',               'source' => 'input', 'source_field' => null, 'tipe' => 'textarea'],
            ['nama' => 'catatan',              'label' => 'Catatan',                  'source' => 'input', 'source_field' => null, 'tipe' => 'textarea'],
            ['nama' => 'nama_usaha',           'label' => 'Nama Usaha',               'source' => 'input', 'source_field' => null, 'tipe' => 'text'],
            ['nama' => 'jenis_usaha',          'label' => 'Jenis Usaha',              'source' => 'input', 'source_field' => null, 'tipe' => 'text'],
            ['nama' => 'alamat_usaha',         'label' => 'Alamat Usaha',             'source' => 'input', 'source_field' => null, 'tipe' => 'textarea'],
            ['nama' => 'luas_tanah',           'label' => 'Luas Tanah',               'source' => 'input', 'source_field' => null, 'tipe' => 'number'],
            ['nama' => 'nomor_sertifikat',     'label' => 'Nomor Sertifikat',         'source' => 'input', 'source_field' => null, 'tipe' => 'text'],
            ['nama' => 'lama_usaha',           'label' => 'Lama Usaha',               'source' => 'input', 'source_field' => null, 'tipe' => 'number'],
            ['nama' => 'penghasilan',          'label' => 'Penghasilan',              'source' => 'input', 'source_field' => null, 'tipe' => 'currency'],
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