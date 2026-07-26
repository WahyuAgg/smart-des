<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Inv\StoreInvDetailPeminjamanRequest;
use App\Http\Requests\Inv\UpdateInvDetailPeminjamanRequest;
use App\Models\InvDetailPeminjaman;
use App\Services\InvMutasiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvDetailPeminjamanController extends ApiController
{
    protected int $defaultPerPage = 50;
    protected int $maxPerPage = 200;

    /** Daftar detail peminjaman — bisa filter berdasarkan peminjaman_id */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) min($request->input('per_page', $this->defaultPerPage), $this->maxPerPage);

        $query = InvDetailPeminjaman::with(['barang', 'peminjaman']);

        if ($request->filled('peminjaman_id')) {
            $query->where('peminjaman_id', $request->input('peminjaman_id'));
        }

        $records = $query->latest()->paginate($perPage);
        return $this->success($records);
    }

    public function show(int $id): JsonResponse
    {
        $record = InvDetailPeminjaman::with(['barang', 'peminjaman'])->findOrFail($id);
        return $this->success($record);
    }

    /** Tambah item ke peminjaman yang sudah ada (hanya jika status 'dipinjam') */
    public function store(StoreInvDetailPeminjamanRequest $request): JsonResponse
    {
        $data = $request->validated();

        $peminjaman = \App\Models\InvPeminjaman::findOrFail($data['peminjaman_id']);
        if ($peminjaman->status !== 'dipinjam') {
            return $this->error('Peminjaman sudah tidak aktif.', null, 422);
        }

        $record = InvDetailPeminjaman::create($data);

        // Update stok via service
        InvMutasiService::pinjam($peminjaman->id, [
            ['barang_id' => $data['barang_id'], 'jumlah' => $data['jumlah_pinjam']]
        ]);

        return $this->success(
            $record->fresh(['barang', 'peminjaman']),
            'Detail peminjaman berhasil ditambahkan.',
            201
        );
    }

    public function update(UpdateInvDetailPeminjamanRequest $request, int $id): JsonResponse
    {
        $record = InvDetailPeminjaman::findOrFail($id);

        if ($record->peminjaman->status !== 'dipinjam') {
            return $this->error('Peminjaman sudah tidak aktif, tidak bisa mengubah detail.', null, 422);
        }

        $record->update($request->validated());
        return $this->success($record->fresh(['barang']), 'Detail peminjaman berhasil diperbarui.');
    }

    public function destroy(int $id): JsonResponse
    {
        $record = InvDetailPeminjaman::findOrFail($id);

        if ($record->peminjaman->status !== 'dipinjam') {
            return $this->error('Peminjaman sudah tidak aktif, tidak bisa menghapus detail.', null, 422);
        }

        // Kembalikan stok
        $barang = $record->barang;
        if ($barang) {
            $barang->decrement('jumlah_dipinjam', $record->jumlah_pinjam);
            $barang->increment('jumlah_tersedia', $record->jumlah_pinjam);
        }

        $record->delete();
        return $this->success(null, 'Detail peminjaman berhasil dihapus.');
    }
}
