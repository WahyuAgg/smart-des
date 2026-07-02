<?php

namespace App\Http\Controllers\Api;

use App\Models\InvBarang;

class InvBarangController extends CrudController
{
    protected string $modelClass = InvBarang::class;
}
