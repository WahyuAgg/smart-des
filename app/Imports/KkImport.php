<?php

namespace App\Imports;

use App\Models\Kk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KkImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Kk::updateOrCreate(
            [
                'no_kk' => $row['no_kk'],
            ],
            [
                'nik_kepala_keluarga' => $row['nik_kepala_keluarga'],
            ]
        );
    }
}