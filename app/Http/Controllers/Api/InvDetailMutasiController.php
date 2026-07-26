<?php

namespace App\Http\Controllers\Api;

use App\Models\InvDetailMutasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvDetailMutasiController extends ApiController
{
    protected int $defaultPerPage = 50;
    protected int $maxPerPage = 200;

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) min($request->input('per_page', $this->defaultPerPage), $this->maxPerPage);

        $query = InvDetailMutasi::with(['barang', 'mutasi']);

        if ($request->filled('mutasi_id')) {
            $query->where('mutasi_id', $request->input('mutasi_id'));
        }

        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->input('barang_id'));
        }

        $records = $query->latest()->paginate($perPage);
        return $this->success($records);
    }

    public function show(int $id): JsonResponse
    {
        $record = InvDetailMutasi::with(['barang', 'mutasi'])->findOrFail($id);
        return $this->success($record);
    }
}