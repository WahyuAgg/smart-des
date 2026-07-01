<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefProfilDesa extends Model
{
    use HasFactory;

    protected $table = 'ref_profil_desa';

    protected $fillable = [
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'nama',
        'kode',
        'kode_pos',
        'alamat',
        'telepon',
        'email',
        'website',
        'logo',
        'visi',
        'misi',
        'deskripsi',
    ];

    public function provinsi()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Province::class, 'provinsi_id', 'id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\City::class, 'kabupaten_id', 'id' );
    }

    public function kecamatan()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\District::class, 'kecamatan_id', 'id' );
    }

    public function desa()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Village::class, 'desa_id', 'id');
    }
}
