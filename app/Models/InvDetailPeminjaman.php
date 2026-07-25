<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $peminjaman_id
 * @property int $barang_id
 * @property int $jumlah_pinjam
 * @property int $jumlah_kembali
 * @property int $jumlah_hilang
 * @property int $jumlah_rusak
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\InvBarang $barang
 * @property-read \App\Models\InvPeminjaman $peminjaman
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman whereJumlahHilang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman whereJumlahKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman whereJumlahPinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman whereJumlahRusak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman wherePeminjamanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailPeminjaman whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class InvDetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'inv_detail_peminjaman';

    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'jumlah_pinjam',
        'jumlah_kembali_baik',
        'jumlah_kembali_rusak',
        'jumlah_hilang',
        'keterangan',
    ];

    protected $casts = [
        'jumlah_pinjam' => 'integer',
        'jumlah_kembali_baik' => 'integer',
        'jumlah_kembali_rusak' => 'integer',
        'jumlah_hilang' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Header Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(InvPeminjaman::class, 'peminjaman_id');
    }

    // Relasi ke Master Barang
    public function barang()
    {
        return $this->belongsTo(InvBarang::class, 'barang_id');
    }
}