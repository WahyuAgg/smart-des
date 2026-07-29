<?php

namespace App\Http\Controllers\Api;

use App\Models\Penduduk;
use App\Models\Kk;
use App\Models\Pendidikan;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends ApiController
{
    public function index(): JsonResponse
    {
        // Total Penduduk (status_hidup = 'hidup')
        $totalPenduduk = Penduduk::query()
            ->where('status_hidup', 'hidup')
            ->count();

        // Jumlah Laki-laki
        $lakiLaki = Penduduk::query()
            ->where('status_hidup', 'hidup')
            ->where('jenis_kelamin', 'Laki-laki')
            ->count();

        // Jumlah Perempuan
        $perempuan = Penduduk::query()
            ->where('status_hidup', 'hidup')
            ->where('jenis_kelamin', 'Perempuan')
            ->count();

        // Jumlah KK
        $jumlahKk = Kk::query()->count();

        // Distribusi Umur (berdasarkan penduduk yang masih hidup)
        $distribusiUmur = Penduduk::query()
            ->select(DB::raw('
                CASE
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 5 THEN "0-4"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 5 AND 9 THEN "5-9"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 10 AND 14 THEN "10-14"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 19 THEN "15-19"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 20 AND 24 THEN "20-24"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 25 AND 29 THEN "25-29"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 30 AND 34 THEN "30-34"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 35 AND 39 THEN "35-39"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 40 AND 44 THEN "40-44"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 45 AND 49 THEN "45-49"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 50 AND 54 THEN "50-54"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 55 AND 59 THEN "55-59"
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 60 AND 64 THEN "60-64"
                    ELSE "65+"
                END AS rentang_umur,
                COUNT(*) AS jumlah
            '))
            ->where('status_hidup', 'hidup')
            ->whereNotNull('tanggal_lahir')
            ->groupBy('rentang_umur')
            ->orderBy(DB::raw('MIN(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()))'))
            ->get()
            ->keyBy('rentang_umur');

        // Distribusi Pendidikan (bergabung dengan tabel pendidikan)
        $distribusiPendidikan = DB::table('penduduk')
            ->join('pendidikan', 'penduduk.pendidikan_id', '=', 'pendidikan.id')
            ->select('pendidikan.tingkat_pendidikan', DB::raw('COUNT(*) as jumlah'))
            ->where('penduduk.status_hidup', 'hidup')
            ->groupBy('pendidikan.tingkat_pendidikan')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Distribusi Pekerjaan
        $distribusiPekerjaan = Penduduk::query()
            ->select('pekerjaan', DB::raw('COUNT(*) as jumlah'))
            ->where('status_hidup', 'hidup')
            ->whereNotNull('pekerjaan')
            ->groupBy('pekerjaan')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Distribusi Agama
        $distribusiAgama = Penduduk::query()
            ->select('agama', DB::raw('COUNT(*) as jumlah'))
            ->where('status_hidup', 'hidup')
            ->whereNotNull('agama')
            ->groupBy('agama')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Tambahkan data penduduk yang belum sekolah / tidak punya pendidikan_id
        $pendudukTanpaPendidikan = Penduduk::query()
            ->where('status_hidup', 'hidup')
            ->whereNull('pendidikan_id')
            ->count();

        return $this->success([
            'total_penduduk' => $totalPenduduk,
            'jumlah_laki_laki' => $lakiLaki,
            'jumlah_perempuan' => $perempuan,
            'jumlah_kk' => $jumlahKk,
            'distribusi_umur' => $distribusiUmur,
            'distribusi_pendidikan' => $distribusiPendidikan,
            'distribusi_pekerjaan' => $distribusiPekerjaan,
            'distribusi_agama' => $distribusiAgama,
        ]);
    }
}