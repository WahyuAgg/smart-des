<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJabatanPerangkat extends Model
{
    use HasFactory;

    protected $table = 'ref_jabatan_perangkat';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'urutan',
        'aktif',
        'dapat_menandatangani',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'dapat_menandatangani' => 'boolean',
    ];

    public function refPerangkatDesa()
    {
        return $this->hasMany(RefPerangkatDesa::class, 'jabatan_perangkat_id');
    }
}
