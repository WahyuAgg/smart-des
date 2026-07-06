<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property string|null $deskripsi
 * @property int $urutan
 * @property bool $aktif
 * @property int $dapat_menandatangani
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RefPerangkatDesa> $refPerangkatDesa
 * @property-read int|null $ref_perangkat_desa_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat whereAktif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat whereDapatMenandatangani($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefJabatanPerangkat whereUrutan($value)
 * @mixin \Eloquent
 */
class RefJabatanPerangkat extends Model
{
    use HasFactory;

    protected $table = 'ref_jabatan_perangkat';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function refPerangkatDesa()
    {
        return $this->hasMany(RefPerangkatDesa::class, 'jabatan_perangkat_id');
    }
}
