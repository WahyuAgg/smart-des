<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $camat
 * @property string|null $nip
 * @property string|null $telepon
 * @property string|null $email
 * @property string|null $foto
 * @property string|null $tanda_tangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan whereCamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan whereTandaTangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan whereTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefKecamatan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RefKecamatan extends Model
{
    use HasFactory;

    protected $table = 'ref_kecamatan';

    protected $fillable = [
        'camat',
        'nip',
        'telepon',
        'email',
        'foto',
        'tanda_tangan',
    ];
    

    protected $hidden = ['created_at', 'updated_at', 'foto', 'tanda_tangan'];
}