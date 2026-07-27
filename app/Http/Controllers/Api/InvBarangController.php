<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Inv\StoreInvBarangRequest;
use App\Http\Requests\Inv\UpdateInvBarangRequest;
use App\Models\InvBarang;
use App\Models\InvDetailMutasi;
use App\Services\InvMutasiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvBarangController extends ApiController
{
    protected int $defaultPerPage = 20;
    protected int $maxPerPage = 100;

    /** Daftar Semua Barang */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) min($request->input('per_page', $this->defaultPerPage), $this->maxPerPage);

        $query = InvBarang::with(['kategori', 'lokasi']);

        // Filter by kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->input('kategori_id'));
        }

        // Filter by lokasi
        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_id', $request->input('lokasi_id'));
        }

        // Search by nama or kode
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        // Filter stok menipis
        if ($request->boolean('stock_minim')) {
            // jumlah_tersedia dihitung real-time: jumlah_total - jumlah_dipinjam
            $query->whereRaw('(jumlah_total - jumlah_dipinjam) <= jumlah_dipinjam');
        }

        $records = $query->latest()->paginate($perPage);

        return $this->success($records);
    }

    /** Detail Barang */
    public function show(int $id): JsonResponse
    {
        $record = InvBarang::with([
            'kategori',
            'lokasi',
            'detailPeminjamans' => function ($query) {
                $query->whereHas('peminjaman', function ($q) {
                    $q->where('status', 'dipinjam');
                })->with('peminjaman');
            },
        ])->findOrFail($id);

        $record->append([
            'jumlah_masih_hilang',
        ]);


        return $this->success($record);
    }


    /** Tambah Barang Baru — stok awal bisa langsung diisi via kolom agregat (non-mutasi). */
    public function store(StoreInvBarangRequest $request): JsonResponse
    {
        $data = $request->validated();

        $jumlahTotalMutasi = $data['jumlah_total'];

        // Default nilai stok
        $data['jumlah_total'] = 0;
        $data['jumlah_dipinjam'] = 0;

        $record = InvBarang::create($data);

        $record->append([
            'jumlah_masih_hilang',
        ]);

        // Catat mutasi pengadaan jika stok awal > 0
        if ($jumlahTotalMutasi > 0) {
            InvMutasiService::pengadaan(
                $record->id,
                $jumlahTotalMutasi,
                'Stok awal barang baru'
            );
        }

        return $this->success(
            $record->fresh(['kategori', 'lokasi']),
            'Barang berhasil ditambahkan.',
            201
        );
    }

    /** Update data master barang (metadata saja, bukan stok) */
    public function update(UpdateInvBarangRequest $request, InvBarang $inv_barang): JsonResponse
    {
        $inv_barang->update($request->validated());

        return $this->success(
            $inv_barang->fresh(['kategori', 'lokasi']),
            'Data barang berhasil diperbarui.'
        );
    }

    /** Hapus Barang */
    public function destroy(int $id): JsonResponse
    {
        $record = InvBarang::findOrFail($id);

        if ($record->detailPeminjamans()->count() > 0 || $record->detailMutasis()->count() > 0) {
            return $this->error(
                'Barang tidak dapat dihapus karena masih memiliki riwayat transaksi.',
                null,
                409
            );
        }

        $record->delete();
        return $this->success(null, 'Barang berhasil dihapus.');
    }

    // ──────────────────────────────────────────────
    //  ENDPOINT MUTASI STOK — KELOMPOK 2 (PLAN)
    // ──────────────────────────────────────────────

    /** POST /inv-barang/{id}/pengadaan */
    public function pengadaan(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $mutasi = InvMutasiService::pengadaan($id, (int) $request->input('jumlah'), $request->input('keterangan'));
            return $this->success($mutasi, 'Pengadaan barang berhasil dicatat.', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->error($e->getMessage(), null, 422);
        }
    }

    /** POST /inv-barang/{id}/hilang */
    public function hilang(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $mutasi = InvMutasiService::hilang($id, (int) $request->input('jumlah'), $request->input('keterangan'));
            return $this->success($mutasi, 'Barang hilang berhasil dicatat.', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->error($e->getMessage(), null, 422);
        }
    }

    /** Post /inv-barang/{id}/ketemu */
    public function ketemu(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $mutasi = InvMutasiService::ketemu($id, (int) $request->input('jumlah'), $request->input('keterangan'));
            return $this->success($mutasi, 'Barang ketemu berhasil dicatat.', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->error($e->getMessage(), null, 422);
        }
    }

    /** POST /inv-barang/{id}/opname */
    public function opname(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'stok_fisik' => 'required|integer|min:0',
            'keterangan'  => 'nullable|string',
        ]);

        try {
            $mutasi = InvMutasiService::opname(
                $id,
                (int) $request->input('stok_fisik'),
                $request->input('keterangan')
            );
            return $this->success($mutasi, 'Stock opname berhasil dicatat.', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->error($e->getMessage(), null, 422);
        }
    }

    /** DELETE /inv-barang/{id}/hapus-stok */
    public function hapusStok(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $mutasi = InvMutasiService::hapus(
                $id,
                (int) $request->input('jumlah'),
                $request->input('keterangan')
            );
            return $this->success($mutasi, 'Penghapusan stok berhasil dicatat.', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->error($e->getMessage(), null, 422);
        }
    }

    // ──────────────────────────────────────────────
    //  ENDPOINT RIWAYAT & MUTASI PER BARANG
    // ──────────────────────────────────────────────

    /** GET /inv-barang/{id}/mutasi — daftar mutasi untuk barang tertentu */
    public function mutasi(Request $request, int $id): JsonResponse
    {
        $perPage = (int) min($request->input('per_page', 20), 100);

        $records = InvDetailMutasi::with('mutasi')
            ->where('barang_id', $id)
            ->latest()
            ->paginate($perPage);

        return $this->success($records);
    }

    /** GET /inv-barang/{id}/riwayat — riwayat peminjaman barang */
    public function riwayat(Request $request, int $id): JsonResponse
    {
        $perPage = (int) min($request->input('per_page', 20), 100);

        $records = \App\Models\InvDetailPeminjaman::with('peminjaman')
            ->where('barang_id', $id)
            ->latest()
            ->paginate($perPage);

        return $this->success($records);
    }
}
