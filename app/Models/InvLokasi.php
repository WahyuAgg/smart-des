<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvBarang> $barangs
 * @property-read int|null $barangs_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvLokasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvLokasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvLokasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvLokasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvLokasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvLokasi whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvLokasi whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvLokasi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvLokasi extends Model
{
    use HasFactory;

    protected $table = 'inv_lokasi';

    protected $fillable = [
        'nama',
        'keterangan',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function barangs()
    {
        return $this->hasMany(InvBarang::class, 'lokasi_id');
    }
}
