<?php

namespace App\Http\Controllers\Api;

use App\Models\Pendidikan;

class PendidikanController extends CrudController
{
    protected string $modelClass = Pendidikan::class;
}
