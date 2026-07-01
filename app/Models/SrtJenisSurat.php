<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrtJenisSurat extends Model
{
    use HasFactory;

    protected $table = 'srt_jenis_surat';

    protected $fillable = [
        'kategori_surat_id',
        'kode_jenis_surat',
        'nama_jenis_surat',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function srtKategoriSurat()
    {
        return $this->belongsTo(SrtKategoriSurat::class, 'kategori_surat_id');
    }

    public function srtMasterFieldSurat()
    {
        return $this->belongsToMany(
            SrtMasterFieldSurat::class,
            'srt_jenis_surat_field',
            'jenis_surat_id',
            'master_field_surat_id'
        )->withPivot([
            'wajib',
            'urutan',
        ])->withTimestamps();
    }

    public function srtPengajuanSurat()
    {
        return $this->hasMany(SrtPengajuanSurat::class, 'jenis_surat_id');
    }

    public function srtJenisSuratField()
    {
        return $this->hasMany(SrtJenisSuratField::class, 'jenis_surat_id');
    }
}
