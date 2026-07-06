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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvKategoriBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvKategoriBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvKategoriBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvKategoriBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvKategoriBarang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvKategoriBarang whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvKategoriBarang whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvKategoriBarang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvKategoriBarang extends Model
{
    use HasFactory;

    protected $table = 'inv_kategori_barang';

    protected $fillable = [
        'nama',
        'keterangan',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function barangs()
    {
        return $this->hasMany(InvBarang::class, 'kategori_barang_id');
    }
}
