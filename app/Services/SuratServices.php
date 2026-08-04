<?php

namespace App\Services;

use App\Models\SrtJenisSurat;

class SuratServices
{
    public function getJenisSurat()
    {
        return SrtJenisSurat::where('is_active', true)
            ->paginate();
    }
}
