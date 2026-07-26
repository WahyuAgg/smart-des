<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Inv\StoreInvKategoriBarangRequest;
use App\Http\Requests\Inv\UpdateInvKategoriBarangRequest;
use App\Models\InvKategoriBarang;
use Illuminate\Http\JsonResponse;

class InvKategoriBarangController extends ApiController
{
    protected int $defaultPerPage = 50;
    protected int $maxPerPage = 200;

    public function index(): JsonResponse
    {
        $data = InvKategoriBarang::withCount('barangs')->latest()->get();
        return $this->success($data);
    }

    public function store(StoreInvKategoriBarangRequest $request): JsonResponse
    {
        $record = InvKategoriBarang::create($request->validated());
        return $this->success($record, 'Kategori barang berhasil ditambahkan.', 201);
    }

    public function show(int $id): JsonResponse
    {
        $record = InvKategoriBarang::with('barangs')->findOrFail($id);
        return $this->success($record);
    }

    public function update(UpdateInvKategoriBarangRequest $request, int $id): JsonResponse
    {
        $record = InvKategoriBarang::findOrFail($id);
        $record->update($request->validated());
        return $this->success($record->fresh(), 'Kategori barang berhasil diperbarui.');
    }

    public function destroy(int $id): JsonResponse
    {
        $record = InvKategoriBarang::findOrFail($id);

        if ($record->barangs()->count() > 0) {
            return $this->error(
                'Kategori tidak dapat dihapus karena masih memiliki ' . $record->barangs()->count() . ' barang terdaftar.',
                null,
                409
            );
        }

        $record->delete();
        return $this->success(null, 'Kategori barang berhasil dihapus.');
    }
}
