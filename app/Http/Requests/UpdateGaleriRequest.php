<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGaleriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:5000',
            'file' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'tanggal' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'file.image' => 'File harus berupa gambar.',
            'file.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'file.max' => 'Ukuran gambar maksimal 10 MB.',
        ];
    }
}