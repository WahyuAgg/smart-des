<?php

namespace App\Http\Controllers\Api;

use App\Models\Alamat;

class AlamatController extends CrudController
{
    protected string $modelClass = Alamat::class;
}
