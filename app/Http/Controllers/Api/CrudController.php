<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class CrudController extends BaseController
{
    protected string $modelClass;

    /**
     * Relationships to eager load.
     */
    protected array $with = [];

    /**
     * Number of records per page.
     */
    protected int $perPage = 15;

    public function index(): JsonResponse
    {
        $records = $this->query(
            $this->resolveModel()
                ->newQuery()
                ->with($this->with)
        )
            ->latest()
            ->paginate($this->perPage);

        return response()->json($records);
    }

    public function store(Request $request): JsonResponse
    {
        $model = $this->resolveModel();

        $data = method_exists($request, 'validated')
            ? $request->validated()
            : $request->only($model->getFillable());

        $record = $model->newQuery()->create($data);

        return response()->json($record->fresh($this->with), 201);
    }

    public function show(string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->with($this->with)
            ->findOrFail($id);

        return response()->json($record);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->findOrFail($id);

        $record->fill(
            $request->only($record->getFillable())
        )->save();

        return response()->json($record->fresh($this->with));
    }

    public function destroy(string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->findOrFail($id);

        $record->delete();

        return response()->json(null, 204);
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
