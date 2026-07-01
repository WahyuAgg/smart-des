<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFieldSurat extends Model
{
    use HasFactory;

    protected $table = 'master_field_surat';

    protected $fillable = [
        'nama',
        'label',
        'tipe',
        'opsi',
        'placeholder',
        'keterangan',
    ];

    protected $casts = [
        'opsi' => 'array',
    ];

    public function jenisSurat()
    {
        return $this->belongsToMany(
            JenisSurat::class,
            'jenis_surat_field',
            'master_field_surat_id',
            'jenis_surat_id'
        )->withPivot([
            'wajib',
            'urutan',
        ])->withTimestamps();
    }

    public function valueFieldSurat()
    {
        return $this->hasMany(
            ValueFieldSurat::class,
            'master_field_surat_id'
        );
    }
}