<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $jabatan_perangkat_id
 * @property string $nama
 * @property string|null $nip
 * @property string|null $telepon
 * @property string|null $email
 * @property string|null $foto
 * @property string|null $tanda_tangan
 * @property \Illuminate\Support\Carbon|null $tanggal_mulai
 * @property \Illuminate\Support\Carbon|null $tanggal_selesai
 * @property bool $aktif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RefJabatanPerangkat $jabatanPerangkat
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereAktif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereJabatanPerangkatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereTandaTangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefPerangkatDesa whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RefPerangkatDesa extends Model
{
    use HasFactory;

    protected $table = 'ref_perangkat_desa';

    protected $fillable = [
        'jabatan_perangkat_id',
        'nama',
        'nip',
        'telepon',
        'email',
        'tanggal_mulai',
        'tanggal_selesai',
        'aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'aktif' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at', 'aktif', 'tanggal_selesai', 'foto', 'tanda_tangan'];

    public function jabatanPerangkat()
    {
        return $this->belongsTo(RefJabatanPerangkat::class, 'jabatan_perangkat_id');
    }
}
