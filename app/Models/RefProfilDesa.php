<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class RefProfilDesa extends Model
{
    use HasFactory;

    protected $table = 'ref_profil_desa';

    protected $fillable = [
        'provinsi_code',
        'kabupaten_code',
        'kecamatan_code',
        'desa_code',
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
        return $this->belongsTo(\Laravolt\Indonesia\Models\Province::class, 'provinsi_code', 'code');
    }

    public function kabupaten()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\City::class, 'kabupaten_code', 'code' );
    }

    public function kecamatan()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\District::class, 'kecamatan_code', 'code' );
    }

    public function desa()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Village::class, 'desa_code', 'code');
    }
}
