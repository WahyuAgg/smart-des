<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValueFieldSurat extends Model
{
    use HasFactory;

    protected $table = 'value_field_surat';
    protected $guarded = ['id'];

    public function pengajuanSurat()
    {
        return $this->belongsTo(PengajuanSurat::class, 'permohonan_surat_id');
    }

    public function fieldSurat()
    {
        return $this->belongsTo(FieldSurat::class, 'field_surat_id');
    }
}
