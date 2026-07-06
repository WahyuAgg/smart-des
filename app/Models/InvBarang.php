<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $kode_barang
 * @property string $nama_barang
 * @property int $kategori_barang_id
 * @property int $lokasi_id
 * @property int $jumlah
 * @property string $satuan
 * @property string $kondisi
 * @property \Illuminate\Support\Carbon|null $tanggal_perolehan
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvDetailPeminjaman> $detailPeminjamans
 * @property-read int|null $detail_peminjamans_count
 * @property-read \App\Models\InvKategoriBarang $kategoriBarang
 * @property-read \App\Models\InvLokasi $lokasi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereKategoriBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereLokasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereTanggalPerolehan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    protected $hidden = ['created_at', 'updated_at'];

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
