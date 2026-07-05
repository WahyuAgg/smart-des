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
        'label_alamat',
        'is_utama',
        'gedung_perumahan',
        'nomor_rumah',
        'blok',
        'no_lantai',
        'no_unit',
        'patokan',
        'alamat_lengkap',
        'jalan',
        'rt',
        'rw',
        'dusun',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'negara',
        'kode_pos',
        'latitude',
        'longitude',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function penduduks()
    {
        return $this->hasMany(Penduduk::class, 'alamat_id');
    }

    protected function alamatFormatted(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $parts = array_filter([
                    // Detail Bangunan
                    $this->gedung_perumahan,
                    $this->nomor_rumah ? "No. {$this->nomor_rumah}" : null,
                    $this->blok ? "Blok {$this->blok}" : null,
                    $this->no_lantai ? "Lantai {$this->no_lantai}" : null,
                    $this->no_unit ? "Unit {$this->no_unit}" : null,

                    // Jalan & Lingkungan
                    $this->jalan,
                    $this->dusun ? "Dusun {$this->dusun}" : null,
                    ($this->rt && $this->rw) ? "RT {$this->rt}/RW {$this->rw}" : null,

                    // Wilayah Administratif
                    $this->desa ? "Desa/Kel. {$this->desa}" : null,
                    $this->kecamatan ? "Kec. {$this->kecamatan}" : null,
                    $this->kabupaten ? "Kab./Kota {$this->kabupaten}" : null,
                    $this->provinsi ? "Prov. {$this->provinsi}" : null,
                    $this->kode_pos,
                ]);

                // Patokan diletakkan di akhir atau bisa disesuaikan posisinya
                if ($this->patokan) {
                    $parts[] = "Patokan: {$this->patokan}";
                }

                return implode(', ', $parts);
            }
        );
    }
}
