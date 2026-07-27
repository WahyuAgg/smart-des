<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\InvKategoriBarang;

class UpdateInvKategoriBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'nama' => ['sometimes', 'string', 'max:100', Rule::unique(InvKategoriBarang::class)
            ->ignore($this->route('inv_kategori_barang'))],
            'keterangan' => 'nullable|string',
        ];
    }
}