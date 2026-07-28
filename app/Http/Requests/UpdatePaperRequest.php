<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaperRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $paperId = $this->route('paper');

        return [
            'judul' => 'sometimes|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('papers', 'slug')->ignore($paperId),
            ],
            'ringkasan' => 'nullable|string|max:5000',
            'nama_penulis' => 'sometimes|string|max:255',
            'tahun' => 'nullable|integer|min:1900|max:' . date('Y'),
            'pdf' => 'nullable|file|mimes:pdf|max:20480',
            'thumbnail' => 'nullable|file|image|max:2048',
            'jumlah_halaman' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published',
        ];
    }
}