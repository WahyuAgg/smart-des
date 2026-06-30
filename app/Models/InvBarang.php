<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvBarang extends Model
{
    use HasFactory;

    protected $table = 'inv_barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_barang_id',
        'lokasi_id',
        'jumlah',
        'satuan',
        'kondisi',
        'tanggal_perolehan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_perolehan' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kategoriBarang()
    {
        return $this->belongsTo(InvKategoriBarang::class, 'kategori_barang_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(InvLokasi::class, 'lokasi_id');
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(InvDetailPeminjaman::class, 'barang_id');
    }
}
