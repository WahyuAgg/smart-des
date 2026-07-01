<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldSurat extends Model
{
    use HasFactory;

    protected $table = 'field_surat';

    protected $fillable = [
        'jenis_surat_id',
        'nama',
        'label',
        'tipe',
        'opsi',
        'wajib',
        'urutan',
        'placeholder',
        'keterangan',
    ];

    protected $casts = [
        'opsi' => 'array',
        'wajib' => 'boolean',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function valueFieldSurat()
    {
        return $this->hasMany(ValueFieldSurat::class, 'field_surat_id');
    }
}
