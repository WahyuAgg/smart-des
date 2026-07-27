<?php

namespace App\Http\Controllers\Api;

use App\Models\RefRt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RefRtController extends CrudController
{
    protected string $modelClass = RefRt::class;

        protected array $withShow = ['refRw', 'refRw.refDusun'];
        protected array $withIndex = ['refRw', 'refRw.refDusun'];

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', $this->defaultPerPage);
        $perPage = min($perPage, $this->maxPerPage);

        $records = $this->resolveModel()
            ->newQuery()
            ->when($request->filled('rw_id'), function ($query) use ($request) {
                $query->where('rw_id', $request->query('rw_id'));
            })
            ->with($this->withIndex)
            ->latest()
            ->paginate($perPage);

        $records->through(function ($item) {
            return $item->append($this->appends);
        });

        return $this->success($records);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'rw_id'    => 'required|integer|exists:ref_rw,id',
            'nomor_rt' => 'required|string|max:3',
            'ketua_rt' => 'nullable|string|max:255',
        ]);

        $record = $this->resolveModel()->newQuery()->create($validated);

        return $this->success(
            $record->fresh($this->withStore),
            'Data berhasil ditambahkan.',
            201
        );
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->findOrFail($id);

        $validated = $request->validate([
            'rw_id'    => 'sometimes|integer|exists:ref_rw,id',
            'nomor_rt' => [
                'sometimes',
                'string',
                'max:3',
                Rule::unique('ref_rt', 'nomor_rt')
                    ->where('rw_id', $request->input('rw_id', $record->rw_id))
                    ->ignore($record->id),
            ],
            'ketua_rt' => 'nullable|string|max:255',
        ]);

        $record->update($validated);

        return $this->success(
            $record->fresh($this->withUpdate),
            'Data berhasil diperbarui.'
        );
    }
}
