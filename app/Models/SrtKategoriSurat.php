<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrtKategoriSurat extends Model
{
    use HasFactory;

    protected $table = 'srt_kategori_surat';

    protected $fillable = [
        'kode_kategori_surat',
        'nama_kategori_surat',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function srtJenisSurat()
    {
        return $this->hasMany(srtJenisSurat::class, 'kategori_surat_id');
    }
}
