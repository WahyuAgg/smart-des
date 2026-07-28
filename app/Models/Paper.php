<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paper extends Model
{
    use HasFactory;

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
        'published_at' => 'datetime', // If using published_at field
    ];

    /**
     * Get the author of the paper.
     */
    // Removed relationship method as we are now storing name directly

}
