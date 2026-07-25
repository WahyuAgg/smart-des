<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

use App\Models\Penduduk;
use App\Models\RefProfilDesa;
use Illuminate\Support\Facades\Storage;

class TestingController extends Controller
{
    public function testing()
    {
        // $data = RefProfilDesa::query()->first()->profile_kecamatan;
        // $data = Penduduk::query()->find(3)->tempat_lahir;

        // $namaFile = 'catatan.txt';
        // $isi = 'Halo, ini adalah isi file teks saya.';




        // // membuat folder 
        // Storage::disk('public')->makeDirectory('testDir');

        // // Menyimpan ke storage/app/public/catatan.txt
        // $data = Storage::disk('public')->put($namaFile, $isi);

        // $path = 'testing/folder';

        // $kecDenganDesaTerbanyak = District::withCount('villages')
        //     ->orderByDesc('villages_count')
        //     ->first();

        // return response()->json([
        //     'data' => $kecDenganDesaTerbanyak,
        // ]);

        $village = Village::first();
        return response()->json([
            "village"=> $village,]);
    }
}
