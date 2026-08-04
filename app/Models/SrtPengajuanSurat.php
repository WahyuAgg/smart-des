<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $jenis_surat_id
 * @property string|null $nomor_surat
 * @property string|null $keperluan
 * @property string $status
 * @property string|null $catatan
 * @property string|null $file_hasil
 * @property \Illuminate\Support\Carbon|null $tanggal_diajukan
 * @property \Illuminate\Support\Carbon|null $tanggal_diproses
 * @property \Illuminate\Support\Carbon|null $tanggal_selesai
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array<array-key, mixed>|null $data_surat
 * @property-read string $template_path
 * @property-read \App\Models\SrtJenisSurat $jenisSurat
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penduduk> $penduduks
 * @property-read int|null $penduduks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SrtPengajuanSuratPenduduk> $srtPengajuanSuratPenduduks
 * @property-read int|null $srt_pengajuan_surat_penduduks_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereDataSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereFileHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereJenisSuratId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereKeperluan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereNomorSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereTanggalDiajukan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereTanggalDiproses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtPengajuanSurat whereUserId($value)
 * @property-read string|null $jenis_surat_nama
 * @mixin \Eloquent
 */
class SrtPengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'srt_pengajuan_surat';

    protected $fillable = [
        'jenis_surat_id',
        'nomor_surat',
        'keperluan',
        'data_surat',
        'status',
        'catatan',
        'file_hasil',
        'tanggal_diajukan',
        'tanggal_diproses',
        'tanggal_selesai',
        'user_id',
    ];

    protected $casts = [
        'tanggal_diajukan' => 'datetime',
        'tanggal_diproses' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'data_surat' => 'array',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [
        'jenis_surat_nama',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(SrtJenisSurat::class, 'jenis_surat_id');
    }

    public function getJenisSuratNamaAttribute(): ?string
    {
        return $this->jenisSurat?->nama_jenis_surat;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTemplatePathAttribute(): string
    {
        return storage_path(
            $this->jenisSurat->template_path
        );
    }

    public function srtPengajuanSuratPenduduks()
    {
        return $this->hasMany(
            SrtPengajuanSuratPenduduk::class,
            'pengajuan_surat_id'
        );
    }

    public function penduduks()
    {
        return $this->belongsToMany(
            Penduduk::class,
            'srt_pengajuan_surat_penduduk',
            'pengajuan_surat_id',
            'penduduk_id'
        )->withPivot('urutan')
            ->orderByPivot('urutan');
    }
}
