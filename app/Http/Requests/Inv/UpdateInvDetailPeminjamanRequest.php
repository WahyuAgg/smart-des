<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvDetailPeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'barang_id'         => 'sometimes|integer|exists:inv_barang,id',
            'jumlah_pinjam'     => 'sometimes|integer|min:0',
            'jumlah_kembali'    => 'sometimes|integer|min:0',
            'jumlah_hilang'     => 'sometimes|integer|min:0',
            'keterangan'        => 'nullable|string',
        ];
    }
}