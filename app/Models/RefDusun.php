<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDusun extends Model
{
    use HasFactory;

    protected $table = 'ref_dusun';

    protected $fillable = [
        'nama',
        'kepala_dusun',
    ];

    public function refRw()
    {
        return $this->hasMany(RefRw::class, 'dusun_id');
    }
}
