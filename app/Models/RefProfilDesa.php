<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefProfilDesa extends Model
{
    use HasFactory;

    protected $table = 'ref_profil_desa';
    protected $guarded = ['id'];

    // Assuming the laravolt/indonesia models exist, you can relate them.
    // Replace with correct namespaces if different.
    public function provinsi()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Province::class, 'provinsi_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\City::class, 'kabupaten_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\District::class, 'kecamatan_id');
    }

    public function desa()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Village::class, 'desa_id');
    }
}
