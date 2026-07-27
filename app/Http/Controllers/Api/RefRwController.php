<?php

namespace App\Http\Controllers\Api;

use App\Models\RefRw;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RefRwController extends CrudController
{
    protected string $modelClass = RefRw::class;

    protected array $withShow = ['refRt', 'refDusun'];
        protected array $withIndex = ['refDusun'];


    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', $this->defaultPerPage);
        $perPage = min($perPage, $this->maxPerPage);

        $records = $this->resolveModel()
            ->newQuery()
            ->when($request->filled('dusun_id'), function ($query) use ($request) {
                $query->where('dusun_id', $request->query('dusun_id'));
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
            'dusun_id' => 'required|integer|exists:ref_dusun,id',
            'nomor_rw' => 'required|string|max:3|unique:ref_rw,nomor_rw',
            'ketua_rw' => 'nullable|string|max:255',
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
            'dusun_id' => 'sometimes|integer|exists:ref_dusun,id',
            'nomor_rw' => [
                'sometimes',
                'string',
                'max:3',
                Rule::unique('ref_rw', 'nomor_rw')->ignore($record->id),
            ],
            'ketua_rw' => 'nullable|string|max:255',
        ]);

        $record->update($validated);

        return $this->success(
            $record->fresh($this->withUpdate),
            'Data berhasil diperbarui.'
        );
    }
}
