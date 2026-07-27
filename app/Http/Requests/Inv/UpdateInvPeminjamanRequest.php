<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\InvPeminjaman;

class UpdateInvPeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomor'                  => ['sometimes', 'string', 'max:50', Rule::unique(InvPeminjaman::class)->ignore($this->route('inv_peminjaman'))],
            'nama_peminjam'          => 'sometimes|string|max:150',
            'tanggal_pinjam'         => 'sometimes|date',
            'tanggal_rencana_kembali' => 'sometimes|date|after_or_equal:tanggal_pinjam',
            'keterangan'             => 'nullable|string',
            'status'                 => 'prohibited',
        ];
    }
}