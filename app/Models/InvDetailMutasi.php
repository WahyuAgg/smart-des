<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $mutasi_id
 * @property int $barang_id
 * @property int $jumlah
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\InvBarang $barang
 * @property-read \App\Models\InvMutasi $mutasi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailMutasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailMutasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailMutasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailMutasi whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailMutasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailMutasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailMutasi whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailMutasi whereMutasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvDetailMutasi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvDetailMutasi extends Model
{
    use HasFactory;

    protected $table = 'inv_detail_mutasi';

    protected $fillable = [
        'mutasi_id',
        'barang_id',
        'jumlah',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Header Mutasi
    public function mutasi()
    {
        return $this->belongsTo(InvMutasi::class, 'mutasi_id');
    }

    // Relasi ke Master Barang
    public function barang()
    {
        return $this->belongsTo(InvBarang::class, 'barang_id');
    }
}