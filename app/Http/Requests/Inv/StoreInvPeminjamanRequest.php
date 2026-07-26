<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvPeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomor'                  => 'required|string|max:50|unique:inv_peminjaman,nomor',
            'nama_peminjam'          => 'required|string|max:150',
            'tanggal_pinjam'         => 'required|date',
            'tanggal_rencana_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keterangan'             => 'nullable|string',
            'details'                => 'required|array|min:1',
            'details.*.barang_id'    => 'required|integer|exists:inv_barang,id',
            'details.*.jumlah'       => 'required|integer|min:1',
        ];
    }
}