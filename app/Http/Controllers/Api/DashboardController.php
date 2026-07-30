<?php

namespace App\Http\Controllers\Api;

use App\Models\Penduduk;
use App\Models\Kk;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends ApiController
{
    public function index(): JsonResponse
    {
        // Total Penduduk (status_hidup = 'hidup')
        $totalPenduduk = Penduduk::query()
            ->where('status_hidup', 'HIDUP')
            ->count();

        // dd($totalPenduduk);

        // Jumlah Laki-laki
        $lakiLaki = Penduduk::query()
            ->where('status_hidup', 'HIDUP')
            ->where('jenis_kelamin', 'L')
            ->count();

        // Jumlah Perempuan
        $perempuan = Penduduk::query()
            ->where('status_hidup', 'HIDUP')
            ->where('jenis_kelamin', 'P')
            ->count();

        // Jumlah KK
        $jumlahKk = Kk::query()->count();

        // Distribusi Umur (dihitung via PHP agar aman dan kompatibel dengan database apapun)
        $rentangList = [
            '0-4', '5-9', '10-14', '15-19', '20-24',
            '25-29', '30-34', '35-39', '40-44', '45-49',
            '50-54', '55-59', '60-64', '65+'
        ];

        $counts = array_fill_keys($rentangList, 0);
        $today = Carbon::today();

        $tanggalLahirList = Penduduk::query()
            ->where('status_hidup', 'HIDUP')
            ->whereNotNull('tanggal_lahir')
            ->pluck('tanggal_lahir');

        foreach ($tanggalLahirList as $tgl) {
            $umur = Carbon::parse($tgl)->diffInYears($today);

            if ($umur < 5) {
                $counts['0-4']++;
            } elseif ($umur <= 9) {
                $counts['5-9']++;
            } elseif ($umur <= 14) {
                $counts['10-14']++;
            } elseif ($umur <= 19) {
                $counts['15-19']++;
            } elseif ($umur <= 24) {
                $counts['20-24']++;
            } elseif ($umur <= 29) {
                $counts['25-29']++;
            } elseif ($umur <= 34) {
                $counts['30-34']++;
            } elseif ($umur <= 39) {
                $counts['35-39']++;
            } elseif ($umur <= 44) {
                $counts['40-44']++;
            } elseif ($umur <= 49) {
                $counts['45-49']++;
            } elseif ($umur <= 54) {
                $counts['50-54']++;
            } elseif ($umur <= 59) {
                $counts['55-59']++;
            } elseif ($umur <= 64) {
                $counts['60-64']++;
            } else {
                $counts['65+']++;
            }
        }

        $distribusiUmur = collect($counts)
            ->filter(fn ($jumlah) => $jumlah > 0)
            ->map(fn ($jumlah, $rentang) => [
                'rentang_umur' => $rentang,
                'jumlah' => $jumlah,
            ]);

        // Distribusi Pendidikan (bergabung dengan tabel pendidikan)
        $distribusiPendidikan = DB::table('penduduk')
            ->join('pendidikan', 'penduduk.pendidikan_id', '=', 'pendidikan.id')
            ->select('pendidikan.tingkat_pendidikan', DB::raw('COUNT(*) as jumlah'))
            ->where('penduduk.status_hidup', 'HIDUP')
            ->groupBy('pendidikan.tingkat_pendidikan')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Distribusi Pekerjaan
        $distribusiPekerjaan = Penduduk::query()
            ->select('pekerjaan', DB::raw('COUNT(*) as jumlah'))
            ->where('status_hidup', 'HIDUP')
            ->whereNotNull('pekerjaan')
            ->groupBy('pekerjaan')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Distribusi Agama
        $distribusiAgama = Penduduk::query()
            ->select('agama', DB::raw('COUNT(*) as jumlah'))
            ->where('status_hidup', 'HIDUP')
            ->whereNotNull('agama')
            ->groupBy('agama')
            ->orderBy('jumlah', 'desc')
            ->get();

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