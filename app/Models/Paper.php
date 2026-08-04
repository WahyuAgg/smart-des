<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $judul
 * @property string $slug
 * @property string|null $ringkasan
 * @property string $nama_penulis
 * @property int|null $tahun
 * @property string|null $pdf_path
 * @property string|null $thumbnail_path
 * @property int $jumlah_halaman
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string|null $pdf_url
 * @property-read string|null $thumbnail_url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereJumlahHalaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereNamaPenulis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper wherePdfPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereRingkasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereThumbnailPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paper withoutTrashed()
 * @mixin \Eloquent
 */
class Paper extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'nama_penulis',
        'tahun',
        'pdf_path',
        'thumbnail_path',
        'jumlah_halaman',
        'status',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'pdf_url',
        'thumbnail_url',
    ];

    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_path
            ? Storage::disk('public')->url($this->pdf_path)
            : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path
            ? Storage::disk('public')->url($this->thumbnail_path)
            : null;
    }
}
