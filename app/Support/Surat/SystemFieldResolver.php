<?php

namespace App\Support\Surat;

use App\Models\SrtPengajuanSurat;

class SystemFieldResolver
{
    public function resolve(
        SrtPengajuanSurat $pengajuan,
        string $field
    ): mixed
    {
        return match ($field) {

            'nomor_surat' => $pengajuan->nomor_surat,

            'tanggal_surat' => now()->translatedFormat('d F Y'),

            'tanggal_cetak' => now()->translatedFormat('d F Y'),

            'tahun' => now()->year,

            'bulan' => now()->translatedFormat('F'),

            'tanggal' => now()->translatedFormat('d'),

            'hari' => now()->translatedFormat('l'),

            'waktu' => now()->translatedFormat('H.i'),

            'hari_tanggal' => now()->translatedFormat('l, d F Y'),

            default => null,
        };
    }
}