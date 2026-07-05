<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kk extends Model
{
    use HasFactory;

    protected $table = 'kk';

    protected $fillable = [
        'no_kk',
        'nik_kepala_keluarga',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function penduduks()
    {
        return $this->hasMany(Penduduk::class, 'kk_id');
    }
}
