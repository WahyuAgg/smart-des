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
        // $perPage = $request->input('per_page', $this->defaultPerPage);

        // $perPage = min($perPage, $this->maxPerPage);

        // 1. Ambil dan sanitasi parameter input
        $level = strtolower($request->query('level', 'provinsi'));
        $search = trim($request->query('search', ''));
        $id_parent = $request->query('parent'); // Untuk filter berdasarkan relasi (misal: ID provinsi untuk mencari kabupaten)
        $code = $request->query('code'); // kode wilayah


        // 2. Tentukan model dan kolom relasi berdasarkan level wilayah
        [$model, $parentColumn] = match ($level) {
            'provinsi'  => [Province::class, null],
            'kabupaten' => [City::class, 'province_code'],
            'kecamatan' => [District::class, 'city_code'],
            'desa'      => [Village::class, 'district_code'],
            default     => [null, null],
        };

        // 3. Validasi level yang tidak terdaftar
        if (! $model) {
            return $this->error('Level wilayah tidak valid.', null, 422);
        }


        // 4. Bangun query dasar
        $query = $model::query()->select(['id', 'code', 'name']);

        // 6. Terapkan filter jika parameter tersedia
        if ($parentColumn && $id_parent) {
            $query->where($parentColumn, $id_parent); // Contoh: Cari kabupaten berdasarkan kode provinsi
        }

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }

        $query->limit(3);


        $data = $query->orderBy('name')->get();


        $formattedData = $data->map(function ($item) {
            return [
                'value' => $item->code,
                'label' => $item->name,
            ];
        });

        return $this->success($formattedData);
    }


    public function showById(string $level, string $id): JsonResponse
    {
        [$model] = match (strtolower($level)) {
            'provinsi'  => [Province::class],
            'kabupaten' => [City::class],
            'kecamatan' => [District::class],
            'desa'      => [Village::class],
            default     => [null],
        };

        if (! $model) {
            return $this->error('Level wilayah tidak valid.', null, 422);
        }

        $record = $model::query()->findOrFail($id);

        return $this->success([
            'type'  => strtolower($level),
            'value' => $record->code,
            'label' => $record->name,
        ]);
    }


    public function showByCode(string $level, string $code): JsonResponse
    {
        [$model] = match (strtolower($level)) {
            'provinsi'  => [Province::class],
            'kabupaten' => [City::class],
            'kecamatan' => [District::class],
            'desa'      => [Village::class],
            default     => [null],
        };

        if (! $model) {
            return $this->error('Level wilayah tidak valid.', null, 422);
        }

        $record = $model::query()->where('code', $code)->firstOrFail();


        return $this->success([
            'type'  => strtolower($level),
            'value' => $record->code,
            'label' => $record->name,
        ]);
    }
}
