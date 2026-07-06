<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $kode_kategori_surat
 * @property string $nama_kategori_surat
 * @property string|null $deskripsi
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SrtJenisSurat> $srtJenisSurat
 * @property-read int|null $srt_jenis_surat_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtKategoriSurat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtKategoriSurat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtKategoriSurat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtKategoriSurat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtKategoriSurat whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtKategoriSurat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtKategoriSurat whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtKategoriSurat whereKodeKategoriSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtKategoriSurat whereNamaKategoriSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtKategoriSurat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SrtKategoriSurat extends Model
{
    use HasFactory;

    protected $table = 'srt_kategori_surat';

    protected $fillable = [
        'kode_kategori_surat',
        'nama_kategori_surat',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function srtJenisSurat()
    {
        return $this->hasMany(srtJenisSurat::class, 'kategori_surat_id');
    }
}
