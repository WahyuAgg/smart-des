<?php

namespace App\Http\Requests\Srt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSrtJenisSuratRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_surat_id' => ['required', 'integer', 'exists:srt_kategori_surat,id'],
            'kode_jenis_surat' => ['required', 'string', 'max:50', 'unique:srt_jenis_surat,kode_jenis_surat'],
            'nama_jenis_surat' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'template' => ['nullable', 'file', 'mimes:docx', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],

            // SrtJenisSuratPenduduk (array of penduduk fields)
            'penduduk_fields' => ['nullable', 'array', 'max:50'],
            'penduduk_fields.*.urutan' => ['required', 'integer', 'min:1', 'max:999'],
            'penduduk_fields.*.kode' => ['required', 'string', 'max:50'],
            'penduduk_fields.*.label' => ['required', 'string', 'max:255'],
            'penduduk_fields.*.deskripsi' => ['nullable', 'string', 'max:1000'],
            'penduduk_fields.*.wajib' => ['nullable', 'boolean'],
        ];
    }
}