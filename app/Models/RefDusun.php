<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama
 * @property string|null $kepala_dusun
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RefRw> $refRw
 * @property-read int|null $ref_rw_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefDusun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefDusun newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefDusun query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefDusun whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefDusun whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefDusun whereKepalaDusun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefDusun whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefDusun whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RefDusun extends Model
{
    use HasFactory;

    protected $table = 'ref_dusun';

    protected $fillable = [
        'nama',
        'kepala_dusun',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function refRw()
    {
        return $this->hasMany(RefRw::class, 'dusun_id');
    }
}
