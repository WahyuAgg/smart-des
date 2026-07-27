<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRefRwRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rwId = $this->route('ref_rw');

        return [
            'dusun_id' => [
                'sometimes',
                'integer',
                'exists:ref_dusun,id',
            ],
            'nomor_rw' => [
                'sometimes',
                'string',
                'max:3',
                Rule::unique('ref_rw', 'nomor_rw')->ignore($rwId),
            ],
            'ketua_rw' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}