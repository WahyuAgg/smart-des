<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;



/**
 * @property int $id
 * @property string|null $label_alamat
 * @property int $is_utama
 * @property string|null $alamat_lengkap
 * @property string|null $jalan
 * @property string|null $gedung_perumahan
 * @property string|null $nomor_rumah
 * @property string|null $blok
 * @property string|null $no_lantai
 * @property string|null $no_unit
 * @property string|null $rt
 * @property string|null $rw
 * @property string|null $desa
 * @property string|null $dusun
 * @property string|null $kecamatan
 * @property string|null $kabupaten
 * @property string|null $provinsi
 * @property string $negara
 * @property string|null $kode_pos
 * @property string|null $patokan
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $alamat_formatted
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penduduk> $penduduks
 * @property-read int|null $penduduks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereAlamatLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereBlok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereDesa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereDusun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereGedungPerumahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereIsUtama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereJalan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereKabupaten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereKecamatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereKodePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereLabelAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereNegara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereNoLantai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereNoUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereNomorRumah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat wherePatokan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereProvinsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alamat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    protected $appends = ['alamat_formatted'];

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
                    $this->desa ? 'Desa/Kel. ' . Str::title(strtolower($this->desa)) : null,
                    $this->kecamatan ? 'Kec. ' . Str::title(strtolower($this->kecamatan)) : null,
                    $this->kabupaten ? Str::title(strtolower($this->kabupaten)) : null,
                    $this->provinsi ? 'Prov. ' . Str::title(strtolower($this->provinsi)) : null,
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
