<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrtValueFieldSurat extends Model
{
    use HasFactory;

    protected $table = 'srt_value_field_surat';

    protected $fillable = [
        'pengajuan_surat_id',
        'master_field_surat_id',
        'value',
    ];

    public function srtPengajuanSurat()
    {
        return $this->belongsTo(SrtPengajuanSurat::class, 'pengajuan_surat_id');
    }

    public function srtMasterFieldSurat()
    {
        return $this->belongsTo(SrtMasterFieldSurat::class, 'master_field_surat_id');
    }
}