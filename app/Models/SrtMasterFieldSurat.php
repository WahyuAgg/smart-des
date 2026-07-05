<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrtMasterFieldSurat extends Model
{
    use HasFactory;

    protected $table = 'srt_master_field_surat';

    public const INPUT_MODE_AUTO = 'auto';

    public const INPUT_MODE_MANUAL = 'manual';

    public const INPUT_MODE_AUTO_EDITABLE = 'auto_editable';

    public const INPUT_MODES = [
        self::INPUT_MODE_AUTO,
        self::INPUT_MODE_MANUAL,
        self::INPUT_MODE_AUTO_EDITABLE,
    ];

    protected $fillable = [
        'nama',
        'label',
        'tipe',
        'opsi',
        'placeholder',
        'keterangan',
        'input_mode',
        'source',
        'source_field',
    ];

    protected $casts = [
        'opsi' => 'array',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
