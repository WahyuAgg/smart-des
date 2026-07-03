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
        'source',
        'source_field',
    ];

    protected $casts = [
        'opsi' => 'array',
    ];

}