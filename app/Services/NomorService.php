<?php

namespace App\Services;

use App\Models\InvMutasi;
use App\Models\InvPeminjaman;

class NomorService
{
    public static function generate(string $jenis): string
    {
        $prefix = match ($jenis) {
            'PENGADAAN' => 'ADQ',
            'PINJAM'    => 'PJM',
            'KEMBALI'   => 'KMB',
            'HILANG'    => 'HLG',
            'KETEMU'    => 'KTM',
            'OPNAME'    => 'OPN',
            'HAPUS'     => 'HPS',
            'PEMINJAMAN'=> 'PJM',
            default     => 'DOC',
        };

        $tanggal = now()->format('Ymd');

        $model = match ($jenis) {
            'PEMINJAMAN' => InvPeminjaman::class,
            default      => InvMutasi::class,
        };

        $lastNomor = $model::whereDate('created_at', today())
            ->where('nomor', 'like', "{$prefix}-{$tanggal}-%")
            ->latest('id')
            ->value('nomor');

        $urutan = 1;

        if ($lastNomor) {
            $urutan = ((int) substr($lastNomor, -3)) + 1;
        }

        return sprintf(
            '%s-%s-%03d',
            $prefix,
            $tanggal,
            $urutan
        );
    }
}