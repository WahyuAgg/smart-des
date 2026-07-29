<?php

namespace App\Http\Controllers\Api;

use Spatie\Permission\Models\Role;
use Illuminate\Http\JsonResponse;

class RoleController extends ApiController
{
    /**
     * Return a list of all roles (id, name).
     * Used by the frontend for role selection dropdowns.
     */
    public function index(): JsonResponse
    {
        $roles = Role::select('id', 'name')
            ->orderBy('name')
            ->get();

        return $this->success($roles);
    }
}