<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrtJenisSuratField extends Model
{
    use HasFactory;

    protected $table = 'srt_jenis_surat_field';

    protected $fillable = [
        'jenis_surat_id',
        'master_field_surat_id',
        'wajib',
        'urutan',
    ];

    public function srtJenisSurat()
    {
        return $this->belongsTo(SrtJenisSurat::class, 'jenis_surat_id');
    }

    public function srtMasterFieldSurat()
    {
        return $this->belongsTo(SrtMasterFieldSurat::class, 'master_field_surat_id');
    }
}
