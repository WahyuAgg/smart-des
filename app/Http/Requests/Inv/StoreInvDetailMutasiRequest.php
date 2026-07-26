<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvDetailMutasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mutasi_id'       => 'required|integer|exists:inv_mutasi,id',
            'barang_id'       => 'required|integer|exists:inv_barang,id',
            'jumlah'          => 'required|integer',
        ];
    }
}