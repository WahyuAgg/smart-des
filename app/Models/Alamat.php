<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Alamat extends Model
{
    use HasFactory;

    protected $table = 'alamat';

    protected $fillable = [
        'alamat_lengkap',
        'jalan',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'latitude',
        'longitude',
    ];

    public function penduduks()
    {
        return $this->hasMany(Penduduk::class, 'alamat_id');
    }

    protected function alamatLengkap(): Attribute
{
    return Attribute::make(
        get: function (): string {

            $parts = array_filter([
                $this->jalan,
                "RT {$this->rt}/RW {$this->rw}",
                "Desa {$this->desa}",
                "Kecamatan {$this->kecamatan}",
                "Kabupaten {$this->kabupaten}",
                "Provinsi {$this->provinsi}",
                $this->kode_pos,
            ]);

            return implode(', ', $parts);
        }
    );
}
}
