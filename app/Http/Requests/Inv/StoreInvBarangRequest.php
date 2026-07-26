<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_barang'      => 'required|string|max:50|unique:inv_barang,kode_barang',
            'nama_barang'      => 'required|string|max:150',
            'kategori_id'      => 'required|integer|exists:inv_kategori_barang,id',
            'lokasi_id'        => 'required|integer|exists:inv_lokasi,id',
            'satuan'           => 'required|string|max:50',
            'tanggal_perolehan' => 'nullable|date',
            'keterangan'       => 'nullable|string',
            'jumlah_total'     => 'required|integer|min:0',
            'jumlah_rusak'     => 'nullable|integer|min:0',
            'jumlah_tersedia'  => 'prohibited',
            'jumlah_dipinjam'  => 'prohibited',
        ];
    }
}
