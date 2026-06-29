<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRt extends Model
{
    use HasFactory;

    protected $table = 'ref_rt';
    protected $guarded = ['id'];

    public function refRw()
    {
        return $this->belongsTo(RefRw::class, 'rw_id');
    }
}
