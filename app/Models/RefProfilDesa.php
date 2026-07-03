<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        return $this->belongsTo(\Laravolt\Indonesia\Models\City::class, 'kabupaten_code', 'code');
    }

    public function kecamatan()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\District::class, 'kecamatan_code', 'code');
    }

    public function desa()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Village::class, 'desa_code', 'code');
    }

    /**
     * Getters untuk nama wilayah
     */


    protected function namaProvinsi(): Attribute
    {
        return Attribute::make(
            get: fn() => ucwords(strtolower($this->provinsi?->name))
        );
    }

    protected function namaKabupaten(): Attribute
    {
        return Attribute::make(
            get: fn() => ucwords(strtolower($this->kabupaten?->name))
        );
    }

    protected function namaKecamatan(): Attribute
    {
        return Attribute::make(
            get: fn() => ucwords(strtolower($this->kecamatan?->name))
        );
    }

    protected function namaDesa(): Attribute
    {
        return Attribute::make(
            get: fn() => ucwords(strtolower($this->desa?->name))
        );
    }


    protected function profileKecamatan(): Attribute
    {
        return Attribute::make(
            get: fn() => RefKecamatan::query()->first()
        );
    }


    // Perangkat Desa
    private function perangkat(string $kode): ?RefPerangkatDesa
    {
        return RefPerangkatDesa::query()
            ->where('aktif', true)
            ->whereHas('jabatanPerangkat', function ($query) use ($kode) {
                $query->where('kode', $kode);
            })
            ->first();
    }

    protected function Kades(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('kades'));
    }

    protected function Sekdes(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('sekdes'));
    }

    protected function kaurTu(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('kaur_tu'));
    }

    protected function kaurKeu(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('kaur_keu'));
    }

    protected function kaurPer(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('kaur_per'));
    }

    protected function kasiPem(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('kasi_pem'));
    }

    protected function kasiKes(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('kasi_kes'));
    }

    protected function kasiPel(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('kasi_pel'));
    }

    protected function kepalaDusun(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('kadus'));
    }

    protected function stafAdm(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('staf_adm'));
    }

    protected function stafKeu(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('staf_keu'));
    }

    protected function stafPer(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('staf_per'));
    }

    protected function stafPel(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('staf_pel'));
    }

    protected function operatorDesa(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('op_desa'));
    }

    protected function bendahara(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('bendahara'));
    }

    protected function pengelolaArsip(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('arsip'));
    }

    protected function stafUmum(): Attribute
    {
        return Attribute::make(get: fn() => $this->perangkat('umum'));
    }
}
