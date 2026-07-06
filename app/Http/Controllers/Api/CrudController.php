<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class CrudController extends ApiController
{
    protected string $modelClass;

    /**
     * Relationships to eager load.
     */
    protected array $with = [];

    protected array $withIndex = [];

    protected array $withShow = [];

    protected array $withStore = [];

    protected array $withUpdate = [];

    /**
     * Number of records per page.
     */
    protected int $perPage = 15;

    public function index(): JsonResponse
    {
        $records = $this->resolveModel()
            ->newQuery()
            ->with($this->withIndex)
            ->latest()
            ->paginate($this->perPage);

        return $this->success($records);
    }

    public function store(Request $request): JsonResponse
    {
        $model = $this->resolveModel();

        $data = method_exists($request, 'validated')
            ? $request->validated()
            : $request->only($model->getFillable());



        $record = $model->newQuery()->create($data);

        return $this->success(
            $record->fresh($this->withStore),
            'Data berhasil ditambahkan.',
            201
        );
    }

    public function show(string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->with($this->withShow)
            ->findOrFail($id);

        return $this->success($record);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->findOrFail($id);

        $data = method_exists($request, 'validated')
            ? $request->validated()
            : $request->only($record->getFillable());

        $record->update($data);

        return $this->success(
            $record->fresh($this->withUpdate),
            'Data berhasil diperbarui.'
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->findOrFail($id);

        $record->delete();

        return $this->success(
            null,
            'Data berhasil dihapus.'
        );
    }

    /**
     * Resolve model instance.
     */
    protected function resolveModel(): Model
    {
        return new $this->modelClass();
    }

    /**
     * Allow child controllers to customize the query.
     */
    protected function query(Builder $query): Builder
    {
        return $query;
    }
}
