<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Casts\Attribute;


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
        'pekerjaan_id',
        'kk_id',
        'nama_ayah_kandung',
        'nama_ibu_kandung',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_meninggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // NAMA PENDUDUK KAPITAL
    protected function namaLengkap(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => mb_strtoupper($value ?? '')
        );
    }


    protected function tanggalLahirFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tanggal_lahir?->translatedFormat('d F Y')
        );
    }

    public function getUmurAttribute(): int
    {
        if (!$this->tanggal_lahir) {
            return 0;
        }

        return Carbon::parse($this->tanggal_lahir)->age;
    }

    protected function noKk(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->kk?->no_kk
        );
    }

    protected function namaPendidikan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pendidikan?->tingkat_pendidikan
        );
    }

    protected function namaPekerjaan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pekerjaan?->nama_pekerjaan
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

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function kk()
    {
        return $this->belongsTo(Kk::class);
    }

    public function srtPengajuanSurat()
    {
        return $this->hasMany(SrtPengajuanSurat::class, 'penduduk_id', 'id');
    }
}
