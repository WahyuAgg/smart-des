<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

use App\Models\SrtJenisSurat;

class SrtJenisSuratController extends CrudController
{
    protected string $modelClass = SrtJenisSurat::class;


    public function show(string $id): JsonResponse
    {
        $jenisSurat = $this->modelClass::with([
            'srtKategoriSurat',
            'srtJenisSuratPenduduks',
        ])->findOrFail($id);

        return response()->json(
            [
                'jenis_surat' => $jenisSurat,
            ]
        );
    }

    

    // protected array $withIndex = [
    //     'srtKategoriSurat',
    // ];

    // protected array $withShow = [
    //     'srtKategoriSurat',
    //     'srtJenisSuratPenduduks',
    // ];

    // protected array $withStore = [
    //     'srtKategoriSurat',
    //     'srtJenisSuratPenduduks',
    // ];

    // protected array $withUpdate = [
    //     'srtKategoriSurat',
    //     'srtJenisSuratPenduduks',
    // ];
}
