<?php

namespace App\Services;

use App\Models\InvBarang;
use App\Models\InvMutasi;
use App\Models\InvDetailMutasi;
use App\Models\InvPeminjaman;
use App\Models\InvDetailPeminjaman;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class InvMutasiService
{
    /**
     * Pengadaan Barang — menambah stok baru.
     * Efek: jumlah_total ↑
     */
    public static function pengadaan(int $barangId, int $jumlah, ?string $keterangan = null): InvMutasi
    {
        return DB::transaction(function () use ($barangId, $jumlah, $keterangan) {
            $barang = InvBarang::findOrFail($barangId);
            $barang->increment('jumlah_total', $jumlah);

            $mutasi = self::createMutasi('PENGADAAN', now(), $keterangan);
            self::createDetailMutasi($mutasi->id, $barangId, $jumlah);

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Peminjaman — dipanggil otomatis saat transaksi peminjaman dibuat.
     * Efek: jumlah_dipinjam ↑
     * Rule: jumlah <= jumlah_total - jumlah_dipinjam (tersedia real-time)
     */
    public static function pinjam(int $peminjamanId, array $details): InvMutasi
    {
        return DB::transaction(function () use ($peminjamanId, $details) {
            $peminjaman = InvPeminjaman::findOrFail($peminjamanId);

            $mutasi = self::createMutasi(
                'PINJAM',
                $peminjaman->tanggal_pinjam,
                "Peminjaman: {$peminjaman->nomor}",
                $peminjamanId
            );

            foreach ($details as $detail) {
                $barang = InvBarang::findOrFail($detail['barang_id']);
                $tersedia = $barang->jumlah_total - $barang->jumlah_dipinjam;

                if ($detail['jumlah'] > $tersedia) {
                    throw new InvalidArgumentException(
                        "Stok {$barang->nama_barang} tidak mencukupi. " .
                            "Tersedia: {$tersedia}, diminta: {$detail['jumlah']}"
                    );
                }

                $barang->increment('jumlah_dipinjam', $detail['jumlah']);

                self::createDetailMutasi($mutasi->id, $detail['barang_id'], $detail['jumlah']);
            }

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Pengembalian Barang — mencatat barang yang dikembalikan dari peminjaman.
     * Efek: jumlah_dipinjam ↓, jumlah_total ↓ (jika hilang)
     * Rule: (jumlah_kembali + jumlah_hilang) <= jumlah_pinjam
     * Otomasi: status peminjaman → 'dikembalikan' jika semua barang kembali.
     */
    public static function kembalikan(int $peminjamanId, array $detailsReturns): InvMutasi
    {
        return DB::transaction(function () use ($peminjamanId, $detailsReturns) {
            $peminjaman = InvPeminjaman::findOrFail($peminjamanId);

            if ($peminjaman->status !== 'dipinjam') {
                throw new InvalidArgumentException(
                    "Peminjaman dengan status '{$peminjaman->status}' tidak dapat dikembalikan."
                );
            }

            $totalDikembalikan = 0;
            $totalDipinjam = 0;
            $semuaLengkap = true;

            $mutasi = self::createMutasi(
                'KEMBALI',
                now(),
                "Pengembalian Peminjaman: {$peminjaman->nomor}",
                $peminjamanId
            );

            foreach ($detailsReturns as $return) {
                $barangId = $return['barang_id'];
                $kembali = (int) ($return['jumlah_kembali'] ?? 0);
                $hilang = (int) ($return['jumlah_hilang'] ?? 0);
                $jumlahKembali = $kembali + $hilang;

                if ($jumlahKembali <= 0) {
                    throw new InvalidArgumentException("Jumlah kembali harus lebih dari 0.");
                }

                $detailPinjam = InvDetailPeminjaman::where('peminjaman_id', $peminjamanId)
                    ->where('barang_id', $barangId)
                    ->firstOrFail();

                $totalKembaliSebelum = $detailPinjam->jumlah_kembali
                    + $detailPinjam->jumlah_hilang;

                if (($totalKembaliSebelum + $jumlahKembali) > $detailPinjam->jumlah_pinjam) {
                    throw new InvalidArgumentException(
                        "Total kembali melebihi jumlah pinjam untuk barang ini."
                    );
                }

                $barang = InvBarang::findOrFail($barangId);

                // Barang kembali (fisik) → kurangi jumlah_dipinjam
                $barang->decrement('jumlah_dipinjam', $jumlahKembali);

                // Barang hilang → kurangi jumlah_total juga
                if ($hilang > 0) {
                    $barang->decrement('jumlah_total', $hilang);
                }

                // Update detail peminjaman
                $detailPinjam->increment('jumlah_kembali', $kembali);
                $detailPinjam->increment('jumlah_hilang', $hilang);

                self::createDetailMutasi($mutasi->id, $barangId, $jumlahKembali);

                $totalDikembalikan += $jumlahKembali;
                $totalDipinjam += $detailPinjam->jumlah_pinjam;

                // Cek apakah detail ini sudah lengkap kembali
                $sudahLengkap = ($detailPinjam->fresh()->jumlah_kembali
                    + $detailPinjam->fresh()->jumlah_hilang) >= $detailPinjam->jumlah_pinjam;
                if (!$sudahLengkap) {
                    $semuaLengkap = false;
                }
            }

            // Update status header peminjaman
            if ($semuaLengkap) {
                $peminjaman->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali' => now()->toDateString(),
                ]);
            } else {
                $peminjaman->update([
                    'tanggal_kembali' => now()->toDateString(),
                ]);
            }

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Kehilangan Barang — menghapus barang dari sistem karena hilang.
     * Efek: jumlah_total ↓
     * Rule: jumlah <= jumlah_total - jumlah_dipinjam (tersedia real-time)
     */
    public static function hilang(int $barangId, int $jumlah, ?string $keterangan = null): InvMutasi
    {
        return DB::transaction(function () use ($barangId, $jumlah, $keterangan) {
            $barang = InvBarang::findOrFail($barangId);
            $tersedia = $barang->jumlah_total - $barang->jumlah_dipinjam;

            if ($jumlah > $tersedia) {
                throw new InvalidArgumentException(
                    "Stok tersedia tidak mencukupi. Tersedia: {$tersedia}"
                );
            }

            $barang->decrement('jumlah_total', $jumlah);

            $mutasi = self::createMutasi('HILANG', now(), $keterangan);
            self::createDetailMutasi($mutasi->id, $barangId, $jumlah);

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Barang ditemukan kembali, kalau tadinya hilang.
     * Efek: jumlah_total ↑
     */
    public static function ketemu(int $barangId, int $jumlahKetemu, ?string $keterangan = null): InvMutasi
    {
        $jumlahHistoryHilang = InvDetailMutasi::whereHas('mutasi', function ($query) {
            $query->where('jenis', 'HILANG');
        })
            ->where('barang_id', $barangId)
            ->sum('jumlah');

        $jumlahHistoryKetemu = InvDetailMutasi::whereHas('mutasi', function ($query) {
            $query->where('jenis', 'KETEMU');
        })
            ->where('barang_id', $barangId)
            ->sum('jumlah');

        $jumlahMasihHilang = $jumlahHistoryHilang - $jumlahHistoryKetemu;

        if ($jumlahKetemu > $jumlahMasihHilang) {
            throw new InvalidArgumentException(
                "Jumlah ditemukan ({$jumlahKetemu}) melebihi jumlah barang yang masih tercatat hilang ({$jumlahMasihHilang}).",
                422
            );
        }

        return DB::transaction(function () use ($barangId, $jumlahKetemu, $keterangan) {
            $barang = InvBarang::findOrFail($barangId);
            $barang->increment('jumlah_total', $jumlahKetemu);

            $mutasi = self::createMutasi('KETEMU', now(), $keterangan);
            self::createDetailMutasi($mutasi->id, $barangId, $jumlahKetemu);

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Stock Opname — penyesuaian stok fisik.
     * Efek: jumlah_total = stokFisik + jumlah_dipinjam
     */
    public static function opname(int $barangId, int $stokFisik, ?string $keterangan = null): InvMutasi
    {
        return DB::transaction(function () use ($barangId, $stokFisik, $keterangan) {
            $barang = InvBarang::findOrFail($barangId);

            $totalBaru = $stokFisik + $barang->jumlah_dipinjam;
            $selisihTotal = $totalBaru - $barang->jumlah_total;

            $barang->update([
                'jumlah_total' => $totalBaru,
            ]);

            $mutasi = self::createMutasi('OPNAME', now(), $keterangan);

            self::createDetailMutasi(
                $mutasi->id,
                $barangId,
                abs($selisihTotal)
            );

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Penghapusan Barang — menghapus barang dari stok.
     * Efek: jumlah_total ↓
     */
    public static function hapus(int $barangId, int $jumlah, ?string $keterangan = null): InvMutasi
    {
        return DB::transaction(function () use ($barangId, $jumlah, $keterangan) {
            $barang = InvBarang::findOrFail($barangId);
            $tersedia = $barang->jumlah_total - $barang->jumlah_dipinjam;

            if ($jumlah > $tersedia) {
                throw new InvalidArgumentException(
                    "Stok tersedia tidak mencukupi. Tersedia: {$tersedia}"
                );
            }

            $barang->decrement('jumlah_total', $jumlah);

            $mutasi = self::createMutasi('HAPUS', now(), $keterangan);
            self::createDetailMutasi($mutasi->id, $barangId, $jumlah);

            return $mutasi->load('details.barang');
        });
    }

    // ──────────────────────────────────────────────
    //  Private Helpers
    // ──────────────────────────────────────────────

    private static function createMutasi(string $jenis, $tanggal, ?string $keterangan = null, ?int $peminjamanId = null): InvMutasi
    {
        return InvMutasi::create([
            'peminjaman_id' => $peminjamanId,
            'nomor'        => self::generateNomorMutasi($jenis),
            'jenis'        => $jenis,
            'tanggal'      => $tanggal,
            'keterangan'   => $keterangan,
        ]);
    }

    private static function createDetailMutasi(int $mutasiId, int $barangId, int $jumlah): InvDetailMutasi
    {
        return InvDetailMutasi::create([
            'mutasi_id' => $mutasiId,
            'barang_id' => $barangId,
            'jumlah'    => $jumlah,
        ]);
    }

    private static function generateNomorMutasi(string $jenis): string
    {
        $prefix = match ($jenis) {
            'PENGADAAN' => 'ADQ',
            'PINJAM'    => 'PJM',
            'KEMBALI'   => 'KMB',
            'HILANG'    => 'HLG',
            'OPNAME'    => 'OPN',
            'HAPUS'     => 'HPS',
            'KETEMU'    => 'KTM',
            default     => 'MUT',
        };

        $date = now()->format('Ymd');
        $count = InvMutasi::whereDate('created_at', today())
            ->where('jenis', $jenis)
            ->count();

        return "{$prefix}-{$date}-" . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }
}
