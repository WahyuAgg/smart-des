<?php

namespace App\Http\Controllers\Api;

use App\Models\InvDetailPeminjaman;

class InvDetailPeminjamanController extends CrudController
{
    protected string $modelClass = InvDetailPeminjaman::class;
}
