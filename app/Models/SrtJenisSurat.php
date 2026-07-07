<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $kategori_surat_id
 * @property string $kode_jenis_surat
 * @property string $nama_jenis_surat
 * @property string|null $deskripsi
 * @property string|null $template_path Lokasi file template surat (.docx) pada storage
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SrtJenisSuratPenduduk> $srtJenisSuratPenduduks
 * @property-read int|null $srt_jenis_surat_penduduks_count
 * @property-read \App\Models\SrtKategoriSurat $srtKategoriSurat
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SrtPengajuanSurat> $srtPengajuanSurat
 * @property-read int|null $srt_pengajuan_surat_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat whereKategoriSuratId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat whereKodeJenisSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat whereNamaJenisSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat whereTemplatePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtJenisSurat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SrtJenisSurat extends Model
{
    use HasFactory;

    protected $table = 'srt_jenis_surat';

    protected $fillable = [
        'kategori_surat_id',
        'kode_jenis_surat',
        'nama_jenis_surat',
        'deskripsi',
        'template_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function srtKategoriSurat()
    {
        return $this->belongsTo(SrtKategoriSurat::class, 'kategori_surat_id');
    }


    public function srtPengajuanSurat()
    {
        return $this->hasMany(SrtPengajuanSurat::class, 'jenis_surat_id');
    }

    public function srtJenisSuratPenduduks()
    {
        return $this->hasMany(
            SrtJenisSuratPenduduk::class,
            'jenis_surat_id'
        )->orderBy('urutan');
    }
}
