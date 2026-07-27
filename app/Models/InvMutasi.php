<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvDetailMutasi;

/**
 * @property int $id
 * @property int|null $peminjaman_id
 * @property string $nomor
 * @property string $jenis
 * @property \Illuminate\Support\Carbon $tanggal
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, InvDetailMutasi> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\InvPeminjaman|null $peminjaman
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi whereNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi wherePeminjamanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvMutasi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvMutasi extends Model
{
    use HasFactory;

    protected $table = 'inv_mutasi';

    protected $fillable = [
        'peminjaman_id', //nullable, exist jika mutasi terjadi karena peminjaman
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