<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

class UserController extends CrudController
{
    protected string $modelClass = User::class;
}
