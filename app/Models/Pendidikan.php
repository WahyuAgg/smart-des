<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    protected $table = 'pendidikan';

    protected $fillable = [
        'tingkat_pendidikan',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function penduduks()
    {
        return $this->hasMany(Penduduk::class, 'pendidikan_id');
    }
}
