<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgamaController extends CrudController
{
    protected string $modelClass = Agama::class;

    public function store(StoreAgamaRequest $request): JsonResponse
    {
        return parent::store($request);
    }
}