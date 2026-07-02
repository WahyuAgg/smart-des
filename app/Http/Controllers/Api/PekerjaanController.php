<?php

namespace App\Http\Controllers\Api;

use App\Models\Pekerjaan;

class PekerjaanController extends CrudController
{
    protected string $modelClass = Pekerjaan::class;
}
