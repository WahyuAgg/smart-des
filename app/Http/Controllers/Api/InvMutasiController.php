<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Inv\StoreInvMutasiRequest;
use App\Models\InvMutasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvMutasiController extends ApiController
{
    protected int $defaultPerPage = 20;
    protected int $maxPerPage = 100;

    /**
     * Daftar Buku Besar Mutasi (Stock Ledger).
     * Filter: jenis, tanggal_from, tanggal_to, barang_id
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) min($request->input('per_page', $this->defaultPerPage), $this->maxPerPage);

        $query = InvMutasi::with(['details.barang', 'peminjaman']);

        // Filter by jenis mutasi
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->input('jenis'));
        }

        // Filter by range tanggal
        if ($request->filled('tanggal_from')) {
            $query->whereDate('tanggal', '>=', $request->input('tanggal_from'));
        }
        if ($request->filled('tanggal_to')) {
            $query->whereDate('tanggal', '<=', $request->input('tanggal_to'));
        }

        // Filter by barang_id (cari di detail)
        if ($request->filled('barang_id')) {
            $barangId = $request->input('barang_id');
            $query->whereHas('details', function ($q) use ($barangId) {
                $q->where('barang_id', $barangId);
            });
        }

        $records = $query->latest()->paginate($perPage);
        return $this->success($records);
    }

    /** Detail Mutasi */
    public function show(int $id): JsonResponse
    {
        $record = InvMutasi::with(['details.barang', 'peminjaman'])->findOrFail($id);
        return $this->success($record);
    }

    /**
     * Buat mutasi manual (umumnya untuk PENGADAAN, OPNAME, RUSAK, HILANG, HAPUS).
     * Untuk PINJAM & KEMBALI sebaiknya via endpoint peminjaman.
     */
    public function store(StoreInvMutasiRequest $request): JsonResponse
    {
        $data = $request->validated();

        $mutasi = \Illuminate\Support\Facades\DB::transaction(function () use ($data) {
            $mutasi = InvMutasi::create([
                'peminjaman_id' => $data['peminjaman_id'] ?? null,
                'nomor'         => $data['nomor'],
                'jenis'         => $data['jenis'],
                'tanggal'       => $data['tanggal'],
                'keterangan'    => $data['keterangan'] ?? null,
            ]);

            foreach ($data['details'] as $detail) {
                $mutasi->details()->create($detail);
            }

            return $mutasi;
        });

        return $this->success(
            $mutasi->fresh(['details.barang']),
            'Mutasi berhasil dicatat.',
            201
        );
    }

    /** Hanya bisa hapus mutasi yang tidak memiliki relasi peminjaman (mutasi mandiri) */
    public function destroy(int $id): JsonResponse
    {
        $record = InvMutasi::findOrFail($id);

        if ($record->peminjaman_id) {
            return $this->error(
                'Mutasi yang terhubung dengan peminjaman tidak dapat dihapus langsung.',
                null,
                409
            );
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($record) {
            $record->details()->delete();
            $record->delete();
        });

        return $this->success(null, 'Mutasi berhasil dihapus.');
    }
}