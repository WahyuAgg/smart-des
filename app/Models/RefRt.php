<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRt extends Model
{
    use HasFactory;

    protected $table = 'ref_rt';

    protected $fillable = [
        'rw_id',
        'nomor_rt',
        'ketua_rt',
    ];

    public function refRw()
    {
        return $this->belongsTo(RefRw::class, 'rw_id');
    }
}
