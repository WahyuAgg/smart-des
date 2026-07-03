<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_meninggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
    public function getNamaPekerjaanAttribute(): ?string
    {
        return $this->pekerjaan?->nama_pekerjaan;
    }

    protected function alamatLengkap(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->alamat?->alamat_lengkap
        );
    }

    protected function alamatProvinsi(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->alamat?->provinsi
        );
    }
    protected function alamatKabupaten(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->alamat?->kabupaten
        );
    }

    protected function alamatKecamatan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->alamat?->kecamatan
        );
    }
    protected function alamatDesa(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->alamat?->desa
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
