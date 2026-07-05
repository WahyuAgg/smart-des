<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPerangkatDesa extends Model
{
    use HasFactory;

    protected $table = 'ref_perangkat_desa';

    protected $fillable = [
        'jabatan_perangkat_id',
        'nama',
        'nip',
        'telepon',
        'email',
        'foto',
        'tanda_tangan',
        'tanggal_mulai',
        'tanggal_selesai',
        'aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'aktif' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function jabatanPerangkat()
    {
        return $this->belongsTo(RefJabatanPerangkat::class, 'jabatan_perangkat_id');
    }
}
