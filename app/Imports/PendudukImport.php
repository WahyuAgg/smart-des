<?php

namespace App\Imports;

use App\Models\Alamat;
use App\Models\Kk;
use App\Models\Penduduk;
use App\Models\Pendidikan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PendudukImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows): void
    {



        foreach ($rows as $row) {

            // dd($rows->first()->toArray());




            $pendidikanList = Pendidikan::all();

            $target = strtolower(preg_replace('/\s+/', '', trim($row['pendidikan_terakhir'])));

            $pendidikan = $pendidikanList->first(function ($item) use ($target) {
                return strtolower(
                    preg_replace('/\s+/', '', $item->tingkat_pendidikan)
                ) === $target;
            });

            $kk = Kk::query()->where('no_kk', trim($row['kk']))->first();

            $rt = filled($row['rt'])
                ? str_pad(trim((string) $row['rt']), 3, '0', STR_PAD_LEFT)
                : null;

            $rw = filled($row['rw'])
                ? str_pad(trim((string) $row['rw']), 3, '0', STR_PAD_LEFT)
                : null;

            $alamatLengkap = empty($rt) || empty($rw)
                ? 'Desa Curug, Kecamatan Ngombol, Kabupaten Purworejo, Jawa Tengah.'
                : sprintf(
                    'Desa Curug, RT %s RW %s, Kecamatan Ngombol, Kabupaten Purworejo, Jawa Tengah.',
                    str_pad($rt, 3, '0', STR_PAD_LEFT),
                    str_pad($rw, 3, '0', STR_PAD_LEFT)
                );

            $alamat = Alamat::updateOrCreate(
                [
                    'alamat_lengkap' => $alamatLengkap,
                ],
                [
                    'jalan' => 'Jln.Lingkar Utara',
                    'rt' => $rt ?: null,
                    'rw' => $rw ?: null,
                    'desa' => 'CURUG',
                    'kecamatan' => 'NGOMBOL',
                    'kabupaten' => 'KABUPATEN PURWOREJO',
                    'provinsi' => 'JAWA TENGAH',
                    'kode_pos' => '54172',
                    'latitude' => -7.783981,
                    'longitude' => 109.961424,
                ]
            );

            // dump($row['tanggal_lahir']);

            $tanggalLahir = \DateTime::createFromFormat(
                'd-m-Y',
                trim($row['tanggal_lahir'])
            );

            if ($tanggalLahir === false) {
                dd([
                    'tanggal' => $row['tanggal_lahir'],
                    'errors' => \DateTime::getLastErrors(),
                ]);
            }

            $jenisKelamin = strtoupper(trim($row['jenis_kelamin']));



            Penduduk::updateOrCreate(
                [
                    'nik' => trim((string) $row['nik']),
                ],
                [
                    'nama_lengkap' => trim($row['nama']),
                    'jenis_kelamin' => str_starts_with($jenisKelamin, 'L')
                        ? 'L'
                        : 'P',



                    'tanggal_lahir' => $tanggalLahir->format('Y-m-d'),

                    'tempat_lahir' => trim($row['tempat_lahir']),
                    'agama' => strtoupper(trim($row['agama'])),
                    'status_perkawinan' => strtoupper(trim($row['status_nikah'])),
                    'kewarganegaraan' => 'INDONESIA',
                    'golongan_darah' => null,
                    'no_hp' => null,
                    'email' => null,
                    'status_hidup' => strtoupper(trim($row['status_hidup'])),
                    'tanggal_meninggal' => null,
                    'alamat_id' => $alamat->id,
                    'pendidikan_id' => $pendidikan?->id,
                    'pekerjaan' => trim($row['pekerjaan']),
                    'kk_id' => $kk?->id,
                    'nama_ayah_kandung' => trim($row['ayah']),
                    'nama_ibu_kandung' => trim($row['ibu']),

                ]
            );
        }
    }
}
