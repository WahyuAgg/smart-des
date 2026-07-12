<?php

namespace App\Http\Controllers\Api;

use App\Models\Pendidikan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PendidikanController extends CrudController
{
    protected string $modelClass = Pendidikan::class;

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', $this->defaultPerPage);

        $perPage = min($perPage, $this->maxPerPage);

        $query = $this->resolveModel()
            ->newQuery()
            ->with($this->withIndex)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('tingkat_pendidikan', 'like', '%' . $request->search . '%');
            });

        $records = $query->latest()->paginate($perPage);

        $records->through(function ($item) {
            return $item->append($this->appends);
        });

        return $this->success($records);
    }
}
