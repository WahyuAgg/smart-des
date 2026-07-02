<?php

namespace App\Http\Controllers\Api;

use App\Models\Penduduk;

class PendudukController extends CrudController
{
    protected string $modelClass = Penduduk::class;
}
