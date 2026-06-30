<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvLokasi extends Model
{
    use HasFactory;

    protected $table = 'inv_lokasi';

    protected $fillable = [
        'nama',
        'keterangan',
    ];

    public function barangs()
    {
        return $this->hasMany(InvBarang::class, 'lokasi_id');
    }
}
