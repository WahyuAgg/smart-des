<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValueFieldSurat extends Model
{
    use HasFactory;

    protected $table = 'value_field_surat';

    protected $fillable = [
        'pengajuan_surat_id',
        'master_field_surat_id',
        'value',
    ];

    public function pengajuanSurat()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_surat_id');
    }

    public function masterFieldSurat()
    {
        return $this->belongsTo(MasterFieldSurat::class, 'master_field_surat_id');
    }
}