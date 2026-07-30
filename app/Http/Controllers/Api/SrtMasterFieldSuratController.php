<?php

namespace App\Http\Controllers\Api;

use App\Models\SrtMasterFieldSurat;
use Illuminate\Http\Request;

class SrtMasterFieldSuratController extends CrudController
{
    protected string $modelClass = SrtMasterFieldSurat::class;

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = min(
            $request->input('per_page', $this->defaultPerPage),
            $this->maxPerPage
        );

        $query = $this->resolveModel()->newQuery()->with($this->withIndex);

        // Pencarian
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('label', 'like', "%{$search}%")
                  ->orWhere('source_field', 'like', "%{$search}%");
            });
        }

        // Filter
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->input('tipe'));
        }
        if ($request->filled('input_mode')) {
            $query->where('input_mode', $request->input('input_mode'));
        }
        if ($request->filled('source')) {
            $query->where('source', $request->input('source'));
        }

        $records = $query->latest()->paginate($perPage);

        $records->through(function ($item) {
            return $item->append($this->appends);
        });

        return $this->success($records);
    }
}
