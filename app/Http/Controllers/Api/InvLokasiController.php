<?php

namespace App\Http\Controllers\Api;

use App\Models\InvLokasi;

class InvLokasiController extends CrudController
{
    protected string $modelClass = InvLokasi::class;
}
