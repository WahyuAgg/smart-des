<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJabatanPerangkat extends Model
{
    use HasFactory;

    protected $table = 'ref_jabatan_perangkat';
    protected $guarded = ['id'];

    public function refPerangkatDesa()
    {
        return $this->hasMany(RefPerangkatDesa::class, 'jabatan_perangkat_id');
    }
}
