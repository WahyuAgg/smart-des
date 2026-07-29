<?php

namespace App\Http\Requests\Srt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSrtJenisSuratRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jenisSuratId = $this->route('srt_jenis_surat');

        return [
            'kategori_surat_id' => ['sometimes', 'integer', 'exists:srt_kategori_surat,id'],
            'kode_jenis_surat' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('srt_jenis_surat', 'kode_jenis_surat')->ignore($jenisSuratId),
            ],
            'nama_jenis_surat' => ['sometimes', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'template' => ['nullable', 'file', 'mimes:docx,doc,pdf', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],

            // SrtJenisSuratPenduduk
            'penduduk_fields' => ['nullable', 'array', 'max:50'],
            'penduduk_fields.*.urutan' => ['required', 'integer', 'min:1', 'max:999'],
            'penduduk_fields.*.kode' => ['required', 'string', 'max:50'],
            'penduduk_fields.*.label' => ['required', 'string', 'max:255'],
            'penduduk_fields.*.deskripsi' => ['nullable', 'string', 'max:1000'],
            'penduduk_fields.*.wajib' => ['nullable', 'boolean'],
        ];
    }
}