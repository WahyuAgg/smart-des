<?php

namespace App\Http\Controllers\Api;

use App\Models\SrtJenisSurat;

class SrtJenisSuratController extends CrudController
{
    protected string $modelClass = SrtJenisSurat::class;

    public function __construct()
    {
        $this->with = [
            'srtKategoriSurat',
            'srtJenisSuratPenduduks',
        ];
    }

}
