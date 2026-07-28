<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRefProfilDesaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'sometimes|string|max:255',
            'kode' => 'nullable|string|max:20',
            'kode_pos' => 'nullable|string|max:10',
            'alamat' => 'nullable|string|max:500',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:255',

            'logo' => 'nullable|file|image|max:2048',

            'visi' => 'nullable|string|max:1000',
            'misi' => 'nullable|array|max:20',
            'misi.*' => 'required|string|max:255',

            'deskripsi' => 'nullable|string|max:2000',

            'peta_pdf' => 'nullable|file|mimes:pdf|max:10240',

            'nama_provinsi' => 'nullable|string|max:100',
            'nama_kabupaten' => 'nullable|string|max:100',
            'nama_kecamatan' => 'nullable|string|max:100',
            'nama_desa' => 'nullable|string|max:100',

            'profil_kecamatan' => 'nullable|array',

            'profil_kecamatan.camat' => 'nullable|string|max:100',
            'profil_kecamatan.nip' => 'nullable|string|max:50',
            'profil_kecamatan.telepon' => 'nullable|string|max:20',
            'profil_kecamatan.email' => 'nullable|email|max:100',
            'profil_kecamatan.foto' => 'nullable|file|image|max:2048',
            'profil_kecamatan.tanda_tangan' => 'nullable|file|image|max:2048',
        ];
    }
}