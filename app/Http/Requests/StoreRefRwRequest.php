<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRefRwRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dusun_id' => [
                'required',
                'integer',
                'exists:ref_dusun,id',
            ],
            'nomor_rw' => [
                'required',
                'string',
                'max:3',
                'unique:ref_rw,nomor_rw',
            ],
            'ketua_rw' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}