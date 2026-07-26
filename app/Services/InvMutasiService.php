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
     * Efek: jumlah_total ↑, jumlah_tersedia ↑
     */
    public static function pengadaan(int $barangId, int $jumlah, ?string $keterangan = null): InvMutasi
    {
        return DB::transaction(function () use ($barangId, $jumlah, $keterangan) {
            $barang = InvBarang::findOrFail($barangId);

            $barang->increment('jumlah_total', $jumlah);
            $barang->increment('jumlah_tersedia', $jumlah);

            $mutasi = self::createMutasi('PENGADAAN', now(), $keterangan);
            self::createDetailMutasi($mutasi->id, $barangId, $jumlah);

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Peminjaman — dipanggil otomatis saat transaksi peminjaman dibuat.
     * Efek: jumlah_tersedia ↓, jumlah_dipinjam ↑
     * Rule: jumlah <= jumlah_tersedia
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

                if ($detail['jumlah'] > $barang->jumlah_tersedia) {
                    throw new InvalidArgumentException(
                        "Stok {$barang->nama_barang} tidak mencukupi. " .
                        "Tersedia: {$barang->jumlah_tersedia}, diminta: {$detail['jumlah']}"
                    );
                }

                $barang->decrement('jumlah_tersedia', $detail['jumlah']);
                $barang->increment('jumlah_dipinjam', $detail['jumlah']);

                self::createDetailMutasi($mutasi->id, $detail['barang_id'], $detail['jumlah']);
            }

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Pengembalian Barang — mencatat barang yang dikembalikan dari peminjaman.
     * Efek: jumlah_dipinjam ↓, jumlah_tersedia ↑ (baik), jumlah_rusak ↑ (rusak),
     *       jumlah_total ↓ & jumlah_tersedia ↓ (hilang)
     * Rule: (baik + rusak + hilang) <= jumlah_pinjam
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
                $baik = (int) ($return['jumlah_kembali_baik'] ?? 0);
                $rusak = (int) ($return['jumlah_kembali_rusak'] ?? 0);
                $hilang = (int) ($return['jumlah_hilang'] ?? 0);
                $jumlahKembali = $baik + $rusak + $hilang;

                if ($jumlahKembali <= 0) {
                    throw new InvalidArgumentException("Jumlah kembali harus lebih dari 0.");
                }

                $detailPinjam = InvDetailPeminjaman::where('peminjaman_id', $peminjamanId)
                    ->where('barang_id', $barangId)
                    ->firstOrFail();

                $totalKembaliSebelum = $detailPinjam->jumlah_kembali_baik
                    + $detailPinjam->jumlah_kembali_rusak
                    + $detailPinjam->jumlah_hilang;

                if (($totalKembaliSebelum + $jumlahKembali) > $detailPinjam->jumlah_pinjam) {
                    throw new InvalidArgumentException(
                        "Total kembali melebihi jumlah pinjam untuk barang ini."
                    );
                }

                $barang = InvBarang::findOrFail($barangId);

                // Update stok agregat
                $barang->decrement('jumlah_dipinjam', $jumlahKembali);
                $barang->increment('jumlah_tersedia', $baik);
                $barang->increment('jumlah_rusak', $rusak);

                if ($hilang > 0) {
                    $barang->decrement('jumlah_total', $hilang);
                }

                // Update detail peminjaman
                $detailPinjam->increment('jumlah_kembali_baik', $baik);
                $detailPinjam->increment('jumlah_kembali_rusak', $rusak);
                $detailPinjam->increment('jumlah_hilang', $hilang);

                self::createDetailMutasi($mutasi->id, $barangId, $jumlahKembali);

                $totalDikembalikan += $jumlahKembali;
                $totalDipinjam += $detailPinjam->jumlah_pinjam;

                // Cek apakah detail ini sudah lengkap kembali
                $sudahLengkap = ($detailPinjam->fresh()->jumlah_kembali_baik
                    + $detailPinjam->fresh()->jumlah_kembali_rusak
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
     * Kerusakan Barang — memindahkan stok baik ke stok rusak.
     * Efek: jumlah_tersedia ↓, jumlah_rusak ↑ (jumlah_total tetap)
     * Rule: jumlah <= jumlah_tersedia
     */
    public static function rusak(int $barangId, int $jumlah, ?string $keterangan = null): InvMutasi
    {
        return DB::transaction(function () use ($barangId, $jumlah, $keterangan) {
            $barang = InvBarang::findOrFail($barangId);

            if ($jumlah > $barang->jumlah_tersedia) {
                throw new InvalidArgumentException(
                    "Stok tersedia tidak mencukupi. Tersedia: {$barang->jumlah_tersedia}"
                );
            }

            $barang->decrement('jumlah_tersedia', $jumlah);
            $barang->increment('jumlah_rusak', $jumlah);

            $mutasi = self::createMutasi('RUSAK', now(), $keterangan);
            self::createDetailMutasi($mutasi->id, $barangId, $jumlah);

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Kehilangan Barang — menghapus barang dari sistem karena hilang.
     * Efek: jumlah_tersedia ↓, jumlah_total ↓
     * Rule: jumlah <= jumlah_tersedia
     */
    public static function hilang(int $barangId, int $jumlah, ?string $keterangan = null): InvMutasi
    {
        return DB::transaction(function () use ($barangId, $jumlah, $keterangan) {
            $barang = InvBarang::findOrFail($barangId);

            if ($jumlah > $barang->jumlah_tersedia) {
                throw new InvalidArgumentException(
                    "Stok tersedia tidak mencukupi. Tersedia: {$barang->jumlah_tersedia}"
                );
            }

            $barang->decrement('jumlah_tersedia', $jumlah);
            $barang->decrement('jumlah_total', $jumlah);

            $mutasi = self::createMutasi('HILANG', now(), $keterangan);
            self::createDetailMutasi($mutasi->id, $barangId, $jumlah);

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Stock Opname — penyesuaian stok fisik.
     * Efek: jumlah_tersedia disesuaikan (+/-), jumlah_total ikut berubah.
     */
    public static function opname(int $barangId, int $jumlahFisik, ?string $keterangan = null): InvMutasi
    {
        return DB::transaction(function () use ($barangId, $jumlahFisik, $keterangan) {
            $barang = InvBarang::findOrFail($barangId);

            $selisih = $jumlahFisik - $barang->jumlah_tersedia;

            if ($selisih !== 0) {
                $barang->increment('jumlah_tersedia', $selisih);
                $barang->increment('jumlah_total', $selisih);
            }

            $mutasi = self::createMutasi('OPNAME', now(), $keterangan);
            self::createDetailMutasi($mutasi->id, $barangId, abs($selisih));

            return $mutasi->load('details.barang');
        });
    }

    /**
     * Penghapusan Barang — menghapus barang dari stok (tersedia atau rusak).
     * Efek: jumlah_total ↓, jumlah_tersedia ↓ (jika dari tersedia)
     *       atau jumlah_rusak ↓ (jika dari rusak)
     */
    public static function hapus(int $barangId, int $jumlah, string $dari = 'tersedia', ?string $keterangan = null): InvMutasi
    {
        return DB::transaction(function () use ($barangId, $jumlah, $dari, $keterangan) {
            $barang = InvBarang::findOrFail($barangId);

            if ($dari === 'tersedia') {
                if ($jumlah > $barang->jumlah_tersedia) {
                    throw new InvalidArgumentException(
                        "Stok tersedia tidak mencukupi. Tersedia: {$barang->jumlah_tersedia}"
                    );
                }
                $barang->decrement('jumlah_tersedia', $jumlah);
            } elseif ($dari === 'rusak') {
                if ($jumlah > $barang->jumlah_rusak) {
                    throw new InvalidArgumentException(
                        "Stok rusak tidak mencukupi. Rusak: {$barang->jumlah_rusak}"
                    );
                }
                $barang->decrement('jumlah_rusak', $jumlah);
            } else {
                throw new InvalidArgumentException("Sumber stok harus 'tersedia' atau 'rusak'.");
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
            'RUSAK'     => 'RSK',
            'OPNAME'    => 'OPN',
            'HAPUS'     => 'HPS',
            default     => 'MUT',
        };

        $date = now()->format('Ymd');
        $count = InvMutasi::whereDate('created_at', today())
            ->where('jenis', $jenis)
            ->count();

        return "{$prefix}-{$date}-" . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }
}