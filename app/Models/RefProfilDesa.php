<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $nama
 * @property string|null $kode
 * @property string|null $kode_pos
 * @property string|null $alamat
 * @property string|null $telepon
 * @property string|null $email
 * @property string|null $website
 * @property string|null $logo
 * @property string|null $visi
 * @property string|null $misi
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $kades
 * @property-read mixed $sekdes
 * @property-read mixed $bendahara
 * @property-read mixed $desa
 * @property-read mixed $kabupaten
 * @property-read mixed $kasi_kes
 * @property-read mixed $kasi_pel
 * @property-read mixed $kasi_pem
 * @property-read mixed $kaur_keu
 * @property-read mixed $kaur_per
 * @property-read mixed $kaur_tu
 * @property-read mixed $kecamatan
 * @property-read mixed $kepala_dusun
 * @property-read mixed $nama_desa
 * @property-read mixed $nama_kabupaten
 * @property-read mixed $nama_kecamatan
 * @property-read mixed $nama_provinsi
 * @property-read mixed $operator_desa
 * @property-read mixed $pengelola_arsip
 * @property-read mixed $profil_kecamatan
 * @property-read mixed $provinsi
 * @property-read mixed $staf_adm
 * @property-read mixed $staf_keu
 * @property-read mixed $staf_pel
 * @property-read mixed $staf_per
 * @property-read mixed $staf_umum
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereKodePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereMisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereVisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefProfilDesa whereWebsite($value)
 * @mixin \Eloquent
 */
class RefProfilDesa extends Model
{
    use HasFactory;

    protected $table = 'ref_profil_desa';

    protected $fillable = [
        'nama',
        'kode',
        'alamat',
        'telepon',
        'email',
        'website',
        'logo',
        'visi',
        'misi',
        'deskripsi',
        'peta_pdf',
    ];

    protected $hidden = ['id','created_at', 'updated_at'];

    protected $casts = [
        'misi' => 'array',
    ];

    protected $appends = [
        'logo_url',
        'peta_pdf_url',
    ];

    /**
     * Getter untuk Wilayah
     */

    public function desa(): Attribute
    {
        return Attribute::make(
            get: fn() => Village::where('code', $this->kode)->first()
        );
    }

    public function kodePos(): Attribute
    {
        return Attribute::make(
            get: fn() => Village::where('code', $this->kode)->first()->meta['pos'] ?? null,
        );
    }


    protected function kecamatan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->desa?->district
        );
    }

    protected function kabupaten(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->kecamatan?->city
        );
    }

    protected function provinsi(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->kabupaten?->province
        );
    }


    /**
     * Getter file url
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo
            ? Storage::disk('public')->url($this->logo)
            : null;
    }

    public function getPetaPdfUrlAttribute(): ?string
    {
        return $this->peta_pdf
            ? Storage::disk('public')->url($this->peta_pdf)
            : null;
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

    protected function profilKecamatan(): Attribute
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
