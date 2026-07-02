<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgamaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode' => [
                'required',
                'string',
                'max:10',
                'unique:ref_agama,kode',
            ],

            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'is_active' => [
                'boolean',
            ],
        ];
    }
}