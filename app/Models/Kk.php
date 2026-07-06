<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $no_kk
 * @property string|null $nik_kepala_keluarga
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penduduk> $penduduks
 * @property-read int|null $penduduks_count
 * @method static \Database\Factories\KkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kk whereNikKepalaKeluarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kk whereNoKk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kk whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Kk extends Model
{
    use HasFactory;

    protected $table = 'kk';

    protected $fillable = [
        'no_kk',
        'nik_kepala_keluarga',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function penduduks()
    {
        return $this->hasMany(Penduduk::class, 'kk_id');
    }
}
