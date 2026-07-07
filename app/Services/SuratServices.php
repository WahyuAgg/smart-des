<?php

namespace App\Services;
use App\Models\SrtJenisSurat;

class SuratService
{
    public function getJenisSurat()
    {
        return SrtJenisSurat::where('is_active', true)
            ->paginate();
    }
}