<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'inv_peminjaman';

    protected $fillable = [
        'nomor',
        'nama_peminjam',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_rencana_kembali' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function detailPeminjamans()
    {
        return $this->hasMany(InvDetailPeminjaman::class, 'peminjaman_id');
    }
}
