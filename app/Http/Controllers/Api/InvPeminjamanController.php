<?php

namespace App\Http\Controllers\Api;

use App\Models\InvPeminjaman;

class InvPeminjamanController extends CrudController
{
    protected string $modelClass = InvPeminjaman::class;
}
