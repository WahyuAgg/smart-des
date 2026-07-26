<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Inv\StoreInvPeminjamanRequest;
use App\Http\Requests\Inv\UpdateInvPeminjamanRequest;
use App\Models\InvPeminjaman;
use App\Services\InvMutasiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvPeminjamanController extends ApiController
{
    protected int $defaultPerPage = 20;
    protected int $maxPerPage = 100;

    /** Daftar Semua Peminjaman */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) min($request->input('per_page', $this->defaultPerPage), $this->maxPerPage);

        $query = InvPeminjaman::with('details.barang');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Search by nomor or nama peminjam
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                  ->orWhere('nama_peminjam', 'like', "%{$search}%");
            });
        }

        $records = $query->latest()->paginate($perPage);

        return $this->success($records);
    }

    /** Detail Peminjaman */
    public function show(int $id): JsonResponse
    {
        $record = InvPeminjaman::with([
            'details.barang',
            'mutasis.details.barang',
        ])->findOrFail($id);

        return $this->success($record);
    }

    /**
     * Buat Peminjaman Baru + otomatis mutasi PINJAM.
     * Body: { nomor, nama_peminjam, tanggal_pinjam, tanggal_rencana_kembali, keterangan, details: [{barang_id, jumlah}] }
     */
    public function store(StoreInvPeminjamanRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = DB::transaction(function () use ($data) {
            // Buat header peminjaman
            $peminjaman = InvPeminjaman::create([
                'nomor'                   => $data['nomor'],
                'nama_peminjam'           => $data['nama_peminjam'],
                'tanggal_pinjam'          => $data['tanggal_pinjam'],
                'tanggal_rencana_kembali' => $data['tanggal_rencana_kembali'],
                'keterangan'              => $data['keterangan'] ?? null,
                'status'                  => 'dipinjam',
            ]);

            // Buat detail peminjaman
            foreach ($data['details'] as $detail) {
                $peminjaman->details()->create([
                    'barang_id'   => $detail['barang_id'],
                    'jumlah_pinjam' => $detail['jumlah'],
                ]);
            }

            // Otomatis catat mutasi PINJAM
            InvMutasiService::pinjam($peminjaman->id, $data['details']);

            return $peminjaman->fresh(['details.barang', 'mutasis.details.barang']);
        });

        return $this->success($result, 'Peminjaman berhasil dicatat.', 201);
    }

    /** Update header peminjaman (hanya jika status masih 'dipinjam') */
    public function update(UpdateInvPeminjamanRequest $request, int $id): JsonResponse
    {
        $record = InvPeminjaman::findOrFail($id);

        if ($record->status !== 'dipinjam') {
            return $this->error(
                'Peminjaman dengan status ' . $record->status . ' tidak dapat diubah.',
                null,
                422
            );
        }

        $record->update($request->validated());

        return $this->success(
            $record->fresh(['details.barang']),
            'Data peminjaman berhasil diperbarui.'
        );
    }

    /** Hapus peminjaman (hanya jika status 'dibatalkan' atau 'dipinjam' & tidak ada mutasi) */
    public function destroy(int $id): JsonResponse
    {
        $record = InvPeminjaman::findOrFail($id);

        if ($record->status === 'dikembalikan') {
            return $this->error('Peminjaman yang sudah dikembalikan tidak dapat dihapus.', null, 409);
        }

        // Hapus detail & mutasi terkait
        DB::transaction(function () use ($record) {
            // Kembalikan stok jika ada mutasi pinjam
            $mutasiPinjam = $record->mutasis()->where('jenis', 'PINJAM')->first();
            if ($mutasiPinjam) {
                foreach ($mutasiPinjam->details as $detail) {
                    $barang = $detail->barang;
                    if ($barang) {
                        $barang->increment('jumlah_tersedia', $detail->jumlah);
                        $barang->decrement('jumlah_dipinjam', $detail->jumlah);
                    }
                }
                $mutasiPinjam->details()->delete();
                $mutasiPinjam->delete();
            }

            $record->details()->delete();
            $record->delete();
        });

        return $this->success(null, 'Peminjaman berhasil dihapus.');
    }

    /**
     * Proses Pengembalian Barang — via endpoint khusus.
     * POST /inv-peminjaman/{id}/kembalikan
     * Body: { returns: [{barang_id, jumlah_kembali_baik, jumlah_kembali_rusak, jumlah_hilang}] }
     */
    public function kembalikan(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'returns'                      => 'required|array|min:1',
            'returns.*.barang_id'          => 'required|integer|exists:inv_barang,id',
            'returns.*.jumlah_kembali_baik' => 'nullable|integer|min:0',
            'returns.*.jumlah_kembali_rusak' => 'nullable|integer|min:0',
            'returns.*.jumlah_hilang'      => 'nullable|integer|min:0',
        ]);

        try {
            $mutasi = InvMutasiService::kembalikan($id, $request->input('returns'));
            return $this->success($mutasi, 'Pengembalian barang berhasil dicatat.', 201);
        } catch (\InvalidArgumentException $e) {
            return $this->error($e->getMessage(), null, 422);
        }
    }

    /** Batalkan peminjaman (status → 'dibatalkan'), stok dikembalikan */
    public function batalkan(int $id): JsonResponse
    {
        return DB::transaction(function () use ($id) {
            $record = InvPeminjaman::findOrFail($id);

            if ($record->status !== 'dipinjam') {
                return $this->error(
                    'Peminjaman dengan status ' . $record->status . ' tidak dapat dibatalkan.',
                    null,
                    422
                );
            }

            // Kembalikan stok
            foreach ($record->details as $detail) {
                $barang = $detail->barang;
                if ($barang) {
                    $barang->decrement('jumlah_dipinjam', $detail->jumlah_pinjam);
                    $barang->increment('jumlah_tersedia', $detail->jumlah_pinjam);
                }
            }

            // Hapus mutasi PINJAM terkait
            $mutasiPinjam = $record->mutasis()->where('jenis', 'PINJAM')->first();
            if ($mutasiPinjam) {
                $mutasiPinjam->details()->delete();
                $mutasiPinjam->delete();
            }

            $record->update(['status' => 'dibatalkan']);

            return $this->success(
                $record->fresh(['details.barang']),
                'Peminjaman berhasil dibatalkan.'
            );
        });
    }
}
