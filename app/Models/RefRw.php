<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $dusun_id
 * @property string $nomor_rw
 * @property string|null $ketua_rw
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RefDusun $refDusun
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RefRt> $refRt
 * @property-read int|null $ref_rt_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRw query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRw whereDusunId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRw whereKetuaRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRw whereNomorRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRw whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RefRw extends Model
{
    use HasFactory;

    protected $table = 'ref_rw';

    protected $fillable = [
        'dusun_id',
        'nomor_rw',
        'ketua_rw',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function refDusun()
    {
        return $this->belongsTo(RefDusun::class, 'dusun_id');
    }

    public function refRt()
    {
        return $this->hasMany(RefRt::class, 'rw_id');
    }
}
