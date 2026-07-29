<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Enums\Agama;
use App\Enums\StatusPerkawinan;

use Illuminate\Database\Eloquent\Casts\Attribute;


/**
 * @property int $id
 * @property string $nik
 * @property string $nama_lengkap
 * @property int $kk_id
 * @property string|null $nama_ayah_kandung
 * @property string|null $nama_ibu_kandung
 * @property string|null $jenis_kelamin
 * @property \Illuminate\Support\Carbon|null $tanggal_lahir
 * @property string|null $tempat_lahir
 * @property string|null $agama
 * @property string|null $pekerjaan
 * @property string|null $status_perkawinan
 * @property string|null $kewarganegaraan
 * @property string|null $golongan_darah
 * @property string|null $no_hp
 * @property string|null $email
 * @property string $status_hidup
 * @property \Illuminate\Support\Carbon|null $tanggal_meninggal
 * @property int|null $alamat_id
 * @property int|null $pendidikan_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Alamat|null $alamat
 * @property-read mixed $get_alamat
 * @property-read \App\Models\Kk $kk
 * @property-read mixed $nama_pendidikan
 * @property-read string|null $no_kk
 * @property-read \App\Models\Pendidikan|null $pendidikan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SrtPengajuanSurat> $pengajuanSurats
 * @property-read int|null $pengajuan_surats_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SrtPengajuanSuratPenduduk> $srtPengajuanSuratPenduduks
 * @property-read int|null $srt_pengajuan_surat_penduduks_count
 * @property-read mixed $tanggal_lahir_f
 * @property-read int|null $umur
 * @method static \Database\Factories\PendudukFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereAlamatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereGolonganDarah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereKewarganegaraan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereKkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereNamaAyahKandung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereNamaIbuKandung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk wherePekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk wherePendidikanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereStatusHidup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereStatusPerkawinan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereTanggalMeninggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penduduk whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'agama',
        'status_perkawinan',
        'kewarganegaraan',
        'golongan_darah',
        'no_hp',
        'email',
        'status_hidup',
        'tanggal_meninggal',
        'alamat_id',
        'pendidikan_id',
        'pekerjaan',
        'kk_id', // nullable - penduduk boleh belum punya KK
        'nama_ayah_kandung',
        'nama_ibu_kandung',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_meninggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        // 'agama' => Agama::class,
        // 'status_perkawinan' => StatusPerkawinan::class,
    ];

    protected $hidden = ['created_at', 'updated_at'];

    // NAMA PENDUDUK KAPITAL
    protected function namaLengkap(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => mb_strtoupper($value ?? '')
        );
    }


    protected function tanggalLahirF(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tanggal_lahir?->translatedFormat('d F Y')
        );
    }



    public function umur(): Attribute
    {
        return Attribute::make(
            get: fn(): ?int =>  $this->tanggal_lahir ? Carbon::parse($this->tanggal_lahir)->age : null
        );
    }

    protected function noKk(): Attribute
    {
        return Attribute::make(
            get: fn() :?string => $this->kk?->no_kk
        );
    }

    protected function namaPendidikan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pendidikan?->tingkat_pendidikan
        );
    }

    protected function tempatLahir(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $this->capitalizeSpecial($value) : null
        );
    }

    protected function pekerjaan(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $this->capitalizeSpecial($value) : null
        );
    }

    protected function jenisKelamin(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? ucfirst(strtolower($value)) : null
        );
    }

    protected function agama(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $this->capitalizeSpecial($value) : null
        );
    }

    protected function kewarganegaraan(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? $this->capitalizeSpecial($value) : null
        );
    }

    protected function getAlamat(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->alamat
        );
    }






    // FUNSGI RELATIONSHIP
    public function alamat()
    {
        return $this->belongsTo(Alamat::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }

    public function kk()
    {
        return $this->belongsTo(Kk::class)->withDefault();
    }


    public function srtPengajuanSuratPenduduks()
    {
        return $this->hasMany(
            SrtPengajuanSuratPenduduk::class,
            'penduduk_id'
        );
    }

    public function pengajuanSurats()
    {
        return $this->belongsToMany(
            SrtPengajuanSurat::class,
            'srt_pengajuan_surat_penduduk',
            'penduduk_id',
            'pengajuan_surat_id'
        )->withPivot('urutan');
    }


    private function capitalizeSpecial($str)
    {
        $str = strtolower($str);


        return preg_replace_callback('/(^|[ \/\-_])([a-z])/', function ($matches) {
            return $matches[1] . strtoupper($matches[2]);
        }, $str);
    }


}
