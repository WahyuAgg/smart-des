<?php

namespace App\Http\Controllers\Api;

use App\Models\RefJabatanPerangkat;
use App\Models\RefPerangkatDesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefPerangkatDesaController extends CrudController
{
    protected string $modelClass = RefPerangkatDesa::class;

    public function index(Request $request): JsonResponse
    {
        $jabatan = RefJabatanPerangkat::query()
            ->with(['refPerangkatDesa' => function ($query) {
                $query->where('aktif', true);
            }])
            ->where('aktif', true)
            ->orderBy('urutan')
            ->get()
            ->map(fn ($item) => $this->formatJabatan($item));

        return $this->success($jabatan);
    }

    public function show(string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->with('jabatanPerangkat')
            ->findOrFail($id);

        $jabatan = $record->jabatanPerangkat;

        return $this->success($this->formatJabatan($jabatan));
    }

    public function store(Request $request): JsonResponse
    {
        $model = $this->resolveModel();

        $data = method_exists($request, 'validated')
            ? $request->validated()
            : $request->only($model->getFillable());

        $jabatanPerangkatId = $data['jabatan_perangkat_id'] ?? null;

        $jabatanPerangkat = RefJabatanPerangkat::find($jabatanPerangkatId);

        if ($jabatanPerangkat->aktif == false){
            return $this->error('Posisi perangkat tidak aktif', 403);
        }

        if ($jabatanPerangkatId) {
            $existingPerangkat = $model->newQuery()
                ->where('jabatan_perangkat_id', $jabatanPerangkatId)
                ->where('aktif', true)
                ->first();

            if ($existingPerangkat) {
                $existingPerangkat->load('jabatanPerangkat');

                return $this->error(
                    'Jabatan ini sudah memiliki perangkat desa yang aktif.',
                    $this->formatJabatan($existingPerangkat->jabatanPerangkat),
                    409
                );
            }
        }

        $record = $model->newQuery()->create($data);

        $record->load('jabatanPerangkat');

        return $this->success(
            $this->formatJabatan($record->jabatanPerangkat),
            'Data berhasil ditambahkan.',
            201
        );
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

        $record->load('jabatanPerangkat');

        return $this->success(
            $this->formatJabatan($record->jabatanPerangkat),
            'Data berhasil diperbarui.'
        );
    }

    private function formatJabatan(RefJabatanPerangkat $jabatan): array
    {
        $perangkat = $jabatan->refPerangkatDesa
            ->where('aktif', true)
            ->first();

        return [
            'kode' => $jabatan->kode,
            'nama' => $jabatan->nama,
            'aktif' => $jabatan->aktif,
            'urutan' => $jabatan->urutan,
            'perangkat' => $perangkat ?: null,
        ];
    }
}
