<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $kode_barang
 * @property string $nama_barang
 * @property int $kategori_id
 * @property int $lokasi_id
 * @property string $satuan
 * @property \Illuminate\Support\Carbon|null $tanggal_perolehan
 * @property string|null $keterangan
 * @property int $jumlah_total
 * @property int $jumlah_dipinjam
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvDetailMutasi> $detailMutasis
 * @property-read int|null $detail_mutasis_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvDetailPeminjaman> $detailPeminjamans
 * @property-read int|null $detail_peminjamans_count
 * @property-read int $jumlah_masih_hilang
 * @property-read int $jumlah_tersedia
 * @property-read \App\Models\InvKategoriBarang $kategori
 * @property-read \App\Models\InvLokasi $lokasi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereJumlahDipinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereJumlahTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvBarang whereKodeBarang($value)
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
        'kategori_id',
        'lokasi_id',
        'satuan',
        'tanggal_perolehan',
        'keterangan',
        'jumlah_total',
        'jumlah_dipinjam',
    ];

    protected $casts = [
        'tanggal_perolehan' => 'date',
        'jumlah_total' => 'integer',
        'jumlah_dipinjam' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
    'jumlah_tersedia',
];

    /**
     * Hitung jumlah tersedia secara real-time.
     * jumlah_tersedia = jumlah_total - jumlah_dipinjam
     */
    public function getJumlahTersediaAttribute(): int
    {
        return $this->jumlah_total - $this->jumlah_dipinjam;
    }

    public function getJumlahMasihHilangAttribute(): int
    {
        $hilang = $this->detailMutasis()
            ->whereHas('mutasi', fn($q) => $q->where('jenis', 'HILANG'))
            ->sum('jumlah');

        $ketemu = $this->detailMutasis()
            ->whereHas('mutasi', fn($q) => $q->where('jenis', 'KETEMU'))
            ->sum('jumlah');

        return $hilang - $ketemu;
    }

    // Relasi ke Kategori Barang
    public function kategori()
    {
        return $this->belongsTo(InvKategoriBarang::class, 'kategori_id');
    }

    // Relasi ke Lokasi
    public function lokasi()
    {
        return $this->belongsTo(InvLokasi::class, 'lokasi_id');
    }

    // Relasi ke Detail Peminjaman
    public function detailPeminjamans()
    {
        return $this->hasMany(InvDetailPeminjaman::class, 'barang_id');
    }

    // Relasi ke Detail Mutasi
    public function detailMutasis()
    {
        return $this->hasMany(InvDetailMutasi::class, 'barang_id');
    }
}
