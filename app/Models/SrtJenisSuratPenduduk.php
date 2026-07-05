<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SrtJenisSuratPenduduk extends Model
{
    use HasFactory;

    protected $table = 'srt_jenis_surat_penduduk';

    protected $fillable = [
        'jenis_surat_id',
        'urutan',
        'kode',
        'label',
        'deskripsi',
    ];

    protected $casts = [
        'wajib' => 'boolean',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(
            SrtJenisSurat::class,
            'jenis_surat_id'
        );
    }
}
