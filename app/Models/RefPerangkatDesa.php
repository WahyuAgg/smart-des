<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPerangkatDesa extends Model
{
    use HasFactory;

    protected $table = 'ref_perangkat_desa';
    protected $guarded = ['id'];

    public function jabatanPerangkat()
    {
        return $this->belongsTo(RefJabatanPerangkat::class, 'jabatan_perangkat_id');
    }
}
