<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nomor
 * @property string $nama_peminjam
 * @property \Illuminate\Support\Carbon $tanggal_pinjam
 * @property \Illuminate\Support\Carbon|null $tanggal_rencana_kembali
 * @property string $status
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvDetailPeminjaman> $detailPeminjamans
 * @property-read int|null $detail_peminjamans_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman whereNamaPeminjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman whereNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman whereTanggalPinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman whereTanggalRencanaKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvPeminjaman whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    protected $hidden = ['created_at', 'updated_at'];

    public function detailPeminjamans()
    {
        return $this->hasMany(InvDetailPeminjaman::class, 'peminjaman_id');
    }
}
