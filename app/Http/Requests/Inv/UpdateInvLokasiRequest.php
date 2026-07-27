<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\InvLokasi;

class UpdateInvLokasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['sometimes', 'string', 'max:100', Rule::unique(InvLokasi::class)
            ->ignore($this->route('inv_lokasi'))],
            'keterangan' => 'nullable|string',
        ];
    }
}