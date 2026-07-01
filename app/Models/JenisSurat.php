<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat';

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

    public function kategoriSurat()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_surat_id');
    }

    public function masterFieldSurat()
    {
        return $this->belongsToMany(
            MasterFieldSurat::class,
            'jenis_surat_field',
            'jenis_surat_id',
            'master_field_surat_id'
        )->withPivot([
            'wajib',
            'urutan',
        ])->withTimestamps();
    }

    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class, 'jenis_surat_id');
    }
}
