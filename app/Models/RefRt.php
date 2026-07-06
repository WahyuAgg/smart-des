<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $rw_id
 * @property string $nomor_rt
 * @property string|null $ketua_rt
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RefRw $refRw
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRt query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRt whereKetuaRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRt whereNomorRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRt whereRwId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefRt whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RefRt extends Model
{
    use HasFactory;

    protected $table = 'ref_rt';

    protected $fillable = [
        'rw_id',
        'nomor_rt',
        'ketua_rt',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function refRw()
    {
        return $this->belongsTo(RefRw::class, 'rw_id');
    }
}
