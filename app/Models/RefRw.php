<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRw extends Model
{
    use HasFactory;

    protected $table = 'ref_rw';

    protected $fillable = [
        'dusun_id',
        'nomor_rw',
        'ketua_rw',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function refDusun()
    {
        return $this->belongsTo(RefDusun::class, 'dusun_id');
    }

    public function refRt()
    {
        return $this->hasMany(RefRt::class, 'rw_id');
    }
}
