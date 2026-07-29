<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string|null $judul
 * @property string|null $deskripsi
 * @property string $file_path
 * @property string|null $tanggal
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string|null $image_url
 * @property-read string|null $image_thumbnail_url
 */
class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeries';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'tanggal',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'tanggal' => 'date',
    ];

    protected $appends = [
        'image_url',
    ];

    protected $hidden = [
        'file_path',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the full URL for the image file.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->file_path
            ? Storage::disk('public')->url($this->file_path)
            : null;
    }
}