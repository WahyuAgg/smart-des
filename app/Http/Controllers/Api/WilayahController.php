<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class WilayahController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $level = strtolower(
            $request->query('level', 'provinsi')
        );

        $search = trim(
            $request->query('search', '')
        );

        $parent = $request->query('parent');
        $id = $request->query('id');
        $value = $request->query('value');

        [$model, $parentColumn] = match ($level) {

            'provinsi' => [
                Province::class,
                null,
            ],

            'kabupaten' => [
                City::class,
                'province_code',
            ],

            'kecamatan' => [
                District::class,
                'city_code',
            ],

            'desa' => [
                Village::class,
                'district_code',
            ],

            default => [
                null,
                null,
            ],
        };

        if (! $model) {
            return $this->error(
                'Level wilayah tidak valid.',
                null,
                422
            );
        }

        if (
            $level === 'desa'
            && ! $parent
            && ! $search
            && ! $id
            && ! $value
        ) {
            return $this->error(
                'Parameter parent, search, id, atau value wajib diisi.'
            );
        }

        /** @var Builder $query */
        $query = $model::query()
            ->select([
                'id',
                'code',
                'name',
            ]);

        if ($parentColumn && $parent) {
            $query->where($parentColumn, $parent);
        }

        if ($id) {
            $query->where('id', $id);
        }

        if ($value) {
            $query->where('code', $value);
        }

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }

        // Lookup / Search
        if ($id || $value || $search !== '') {

            $data = $query
                ->orderBy('name')
                ->get()
                ->map(fn ($item) => [
                    'id' => $item->id,
                    'value' => $item->code,
                    'label' => $item->name,
                ]);

            return $this->success($data);
        }

        // Browse
        $data = $query
            ->orderBy('name')
            ->paginate(
                min(
                    $request->integer('per_page', 20),
                    100
                )
            );

        $data->through(fn ($item) => [
            'id' => $item->id,
            'value' => $item->code,
            'label' => $item->name,
        ]);

        return $this->success($data);
    }
}