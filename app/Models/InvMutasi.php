<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvDetailMutasi;

class InvMutasi extends Model
{
    use HasFactory;

    protected $table = 'inv_mutasi';

    protected $fillable = [
        'peminjaman_id',
        'nomor',
        'jenis',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Header Peminjaman (Nullable)
    public function peminjaman()
    {
        return $this->belongsTo(InvPeminjaman::class, 'peminjaman_id');
    }

    // Relasi ke detail mutasi
    public function details()
    {
        return $this->hasMany(InvDetailMutasi::class, 'mutasi_id');
    }
}