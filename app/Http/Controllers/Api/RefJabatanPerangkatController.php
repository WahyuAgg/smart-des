<?php

namespace App\Http\Controllers\Api;

use App\Models\RefJabatanPerangkat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefJabatanPerangkatController extends CrudController
{
    protected string $modelClass = RefJabatanPerangkat::class;

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', $this->defaultPerPage);
        $perPage = min($perPage, $this->maxPerPage);

        $query = $this->resolveModel()->newQuery()->with($this->withIndex);

        // Filter by aktif
        if ($request->has('aktif')) {
            $aktif = filter_var($request->input('aktif'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($aktif !== null) {
                $query->where('aktif', $aktif);
            }
        }

        // Search by kode, nama, deskripsi
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
                //   ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $records = $query->orderBy('urutan')->paginate($perPage);

        $records->through(function ($item) {
            return $item->append($this->appends);
        });

        return $this->success($records);
    }
}
