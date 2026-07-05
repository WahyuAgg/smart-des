<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrtPengajuanSuratPenduduk extends Model
{
    use HasFactory;

    protected $table = 'srt_pengajuan_surat_penduduk';

    protected $fillable = [
        'pengajuan_surat_id',
        'penduduk_id',
        'urutan',
    ];

    public function pengajuanSurat()
    {
        return $this->belongsTo(
            SrtPengajuanSurat::class,
            'pengajuan_surat_id'
        );
    }

    public function penduduk()
    {
        return $this->belongsTo(
            Penduduk::class,
            'penduduk_id'
        );
    }
}