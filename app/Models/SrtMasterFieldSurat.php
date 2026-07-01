<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrtMasterFieldSurat extends Model
{
    use HasFactory;

    protected $table = 'srt_master_field_surat';

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

    public function srtJenisSurat()
    {
        return $this->belongsToMany(
            SrtJenisSurat::class,
            'srt_jenis_surat_field',
            'master_field_surat_id',
            'jenis_surat_id'
        )->withPivot([
            'wajib',
            'urutan',
        ])->withTimestamps();
    }

    public function srtValueFieldSurat()
    {
        return $this->hasMany(
            SrtValueFieldSurat::class,
            'master_field_surat_id'
        );
    }

    public function srtJenisSuratField()
    {
        return $this->hasMany(
            SrtJenisSuratField::class,
            'master_field_surat_id'
        );
    }
}