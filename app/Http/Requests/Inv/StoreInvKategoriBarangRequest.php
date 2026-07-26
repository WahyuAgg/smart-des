<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvKategoriBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:100|unique:inv_kategori_barang,nama',
            'keterangan' => 'nullable|string',
        ];
    }
}