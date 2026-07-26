<?php

namespace App\Http\Requests\Inv;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvLokasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'nama' => ['sometimes', 'string', 'max:100', Rule::unique('inv_lokasi', 'nama')->ignore($id)],
            'keterangan' => 'nullable|string',
        ];
    }
}