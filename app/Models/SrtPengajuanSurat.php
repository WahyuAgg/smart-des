<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrtPengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'srt_pengajuan_surat';

    protected $fillable = [
        'jenis_surat_id',
        'penduduk_id',
        'nomor_surat',
        'keperluan',
        'data_surat',
        'status',
        'catatan',
        'file_hasil',
        'tanggal_diajukan',
        'tanggal_diproses',
        'tanggal_selesai',
        'user_id',
    ];

    protected $casts = [
        'tanggal_diajukan' => 'datetime',
        'tanggal_diproses' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'data_surat' => 'array',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(SrtJenisSurat::class, 'jenis_surat_id');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTemplatePathAttribute(): string
    {
        return storage_path(
            $this->jenisSurat->template_path
        );
    }
}
