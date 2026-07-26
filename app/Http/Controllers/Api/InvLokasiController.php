<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Inv\StoreInvLokasiRequest;
use App\Http\Requests\Inv\UpdateInvLokasiRequest;
use App\Models\InvLokasi;
use Illuminate\Http\JsonResponse;

class InvLokasiController extends ApiController
{
    protected int $defaultPerPage = 50;
    protected int $maxPerPage = 200;

    public function index(): JsonResponse
    {
        $data = InvLokasi::withCount('barangs')->latest()->get();
        return $this->success($data);
    }

    public function store(StoreInvLokasiRequest $request): JsonResponse
    {
        $record = InvLokasi::create($request->validated());
        return $this->success($record, 'Lokasi berhasil ditambahkan.', 201);
    }

    public function show(int $id): JsonResponse
    {
        $record = InvLokasi::with('barangs')->findOrFail($id);
        return $this->success($record);
    }

    public function update(UpdateInvLokasiRequest $request, int $id): JsonResponse
    {
        $record = InvLokasi::findOrFail($id);
        $record->update($request->validated());
        return $this->success($record->fresh(), 'Lokasi berhasil diperbarui.');
    }

    public function destroy(int $id): JsonResponse
    {
        $record = InvLokasi::findOrFail($id);

        if ($record->barangs()->count() > 0) {
            return $this->error(
                'Lokasi tidak dapat dihapus karena masih memiliki ' . $record->barangs()->count() . ' barang terdaftar.',
                null,
                409
            );
        }

        $record->delete();
        return $this->success(null, 'Lokasi berhasil dihapus.');
    }
}
