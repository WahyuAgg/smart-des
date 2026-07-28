<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Storage;

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
