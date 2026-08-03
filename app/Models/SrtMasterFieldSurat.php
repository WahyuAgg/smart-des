<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int $id
 * @property string $nama
 * @property string $label
 * @property string|null $source
 * @property string|null $source_field
 * @property string $input_mode
 * @property string $tipe
 * @property array<array-key, mixed>|null $opsi
 * @property string|null $placeholder
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereInputMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereOpsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat wherePlaceholder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereSourceField($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SrtMasterFieldSurat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SrtMasterFieldSurat extends Model
{
    use HasFactory;

    protected $table = 'srt_master_field_surat';

    public const INPUT_MODE_AUTO = 'auto';

    public const INPUT_MODE_MANUAL = 'manual';

    public const INPUT_MODE_AUTO_EDITABLE = 'auto_editable';


    protected $fillable = [
        'nama',
        'label',
        'tipe',
        'opsi',
        'placeholder',
        'keterangan',
        'input_mode',
        'source', //dropdown hardcode "penduduk", null, "system", "profil_desa", "jenis_surat"
        'source_field',
    ];

    protected $casts = [
        'opsi' => 'array',
    ];
    protected $appends = [
        'nama_formatted',
    ];

    protected $hidden = ['created_at', 'updated_at'];


    protected function namaFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => '${' . $this->nama . '}'
        );
    }
}
