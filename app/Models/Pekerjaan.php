<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan';

    protected $fillable = [
        'nama_pekerjaan',
    ];

    public function penduduks()
    {
        return $this->hasMany(Penduduk::class, 'pekerjaan_id');
    }
}
