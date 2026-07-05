<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvKategoriBarang extends Model
{
    use HasFactory;

    protected $table = 'inv_kategori_barang';

    protected $fillable = [
        'nama',
        'keterangan',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function barangs()
    {
        return $this->hasMany(InvBarang::class, 'kategori_barang_id');
    }
}
