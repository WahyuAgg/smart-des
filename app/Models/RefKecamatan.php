<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefKecamatan extends Model
{
    use HasFactory;

    protected $table = 'ref_kecamatan';

    protected $fillable = [
        'nama',
        'nama_pejabat',
        'nip',
        'telepon',
        'email',
        'foto',
        'tanda_tangan',
    ];
}