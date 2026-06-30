<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvDetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'inv_detail_peminjaman';

    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'jumlah_pinjam',
        'jumlah_kembali',
        'jumlah_hilang',
        'jumlah_rusak',
        'keterangan',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(InvPeminjaman::class, 'peminjaman_id');
    }

    public function barang()
    {
        return $this->belongsTo(InvBarang::class, 'barang_id');
    }
}
