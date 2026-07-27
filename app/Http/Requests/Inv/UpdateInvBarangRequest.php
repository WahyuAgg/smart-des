<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
{
    return [
        'kode_barang' => [
            'sometimes',
            'string',
            'max:50',
            Rule::unique('inv_barang', 'kode_barang')
                ->ignore($this->route('inv_barang')),
        ],
        'nama_barang' => 'sometimes|string|max:150',
        'kategori_id' => 'sometimes|integer|exists:inv_kategori_barang,id',
        'lokasi_id' => 'sometimes|integer|exists:inv_lokasi,id',
        'satuan' => 'sometimes|string|max:50',
        'tanggal_perolehan' => 'sometimes|nullable|date',
        'keterangan' => 'nullable|string',

        'jumlah_total' => 'prohibited',
        'jumlah_dipinjam' => 'prohibited',
    ];
}
}