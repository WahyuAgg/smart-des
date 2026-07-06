<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $tingkat_pendidikan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penduduk> $penduduks
 * @property-read int|null $penduduks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pendidikan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pendidikan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pendidikan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pendidikan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pendidikan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pendidikan whereTingkatPendidikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pendidikan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pendidikan extends Model
{
    use HasFactory;

    protected $table = 'pendidikan';

    protected $fillable = [
        'tingkat_pendidikan',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function penduduks()
    {
        return $this->hasMany(Penduduk::class, 'pendidikan_id');
    }
}
