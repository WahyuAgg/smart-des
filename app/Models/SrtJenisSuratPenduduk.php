<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @property int $id
 * @property int $jenis_surat_id
 * @property int $urutan
 * @property string $kode
 * @property string $label
 * @property string|null $deskripsi
 * @property bool $wajib
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SrtJenisSurat $jenisSurat
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk whereJenisSuratId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk whereUrutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSuratPenduduk whereWajib($value)
 * @mixin \Eloquent
 */
class SrtJenisSuratPenduduk extends Model
{
    use HasFactory;

    protected $table = 'srt_jenis_surat_penduduk';

    protected $fillable = [
        'jenis_surat_id',
        'urutan',
        'kode',
        'label',
        'deskripsi',
        'wajib',
    ];

    protected $casts = [
        'wajib' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function jenisSurat()
    {
        return $this->belongsTo(
            SrtJenisSurat::class,
            'jenis_surat_id'
        );
    }
}
