<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $pengajuan_surat_id
 * @property int $penduduk_id
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Penduduk|null $penduduk
 * @property-read \App\Models\SrtPengajuanSurat|null $pengajuanSurat
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSuratPenduduk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSuratPenduduk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSuratPenduduk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSuratPenduduk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSuratPenduduk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSuratPenduduk wherePendudukId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSuratPenduduk wherePengajuanSuratId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSuratPenduduk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSuratPenduduk whereUrutan($value)
 * @mixin \Eloquent
 */
class SrtPengajuanSuratPenduduk extends Model
{
    use HasFactory;

    protected $table = 'srt_pengajuan_surat_penduduk';

    protected $fillable = [
        'pengajuan_surat_id',
        'penduduk_id',
        'urutan',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function pengajuanSurat()
    {
        return $this->belongsTo(
            SrtPengajuanSurat::class,
            'pengajuan_surat_id'
        );
    }

    public function penduduk()
    {
        return $this->belongsTo(
            Penduduk::class,
            'penduduk_id'
        );
    }
}