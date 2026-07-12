<?php

namespace App\Http\Controllers\Api;

use App\Models\Kk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KkController extends CrudController
{
    protected string $modelClass = Kk::class;

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', $this->defaultPerPage);

        $perPage = min($perPage, $this->maxPerPage);

        $query = $this->resolveModel()
            ->newQuery()
            ->with($this->withIndex)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('no_kk', 'like', '%' . $request->search . '%');
            });

        $records = $query->latest()->paginate($perPage);

        $records->through(function ($item) {
            return $item->append($this->appends);
        });

        return $this->success($records);
    }
}
