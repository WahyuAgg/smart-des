<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvMutasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'peminjaman_id' => 'prohibited', // ini hanya boleh jika mutasi berasal dari peminjaman
            'nomor'         => 'required|string|max:50|unique:inv_mutasi,nomor',
            'jenis'         => 'required|string|in:PENGADAAN,PINJAM,KEMBALI,HILANG,OPNAME,HAPUS',
            'tanggal'       => 'required|date',
            'keterangan'    => 'nullable|string',
            'details'       => 'required|array|min:1',
            'details.*.barang_id' => 'required|integer|exists:inv_barang,id',
            'details.*.jumlah'   => 'required|integer',
        ];
    }
}