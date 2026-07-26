<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvDetailPeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'peminjaman_id'     => 'required|integer|exists:inv_peminjaman,id',
            'barang_id'         => 'required|integer|exists:inv_barang,id',
            'jumlah_pinjam'     => 'required|integer|min:1',
            'keterangan'        => 'nullable|string',
        ];
    }
}