<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRw extends Model
{
    use HasFactory;

    protected $table = 'ref_rw';
    protected $guarded = ['id'];

    public function refDusun()
    {
        return $this->belongsTo(RefDusun::class, 'dusun_id');
    }

    public function refRt()
    {
        return $this->hasMany(RefRt::class, 'rw_id');
    }
}
