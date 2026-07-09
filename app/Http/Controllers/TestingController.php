<?php

namespace App\Http\Controllers;

// use App\Models\Penduduk;
// use App\Models\RefProfilDesa;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;

use App\Models\Penduduk;
use App\Models\RefProfilDesa;
use Illuminate\Support\Facades\Storage;

class TestingController extends Controller
{
    public function testing()
    {
        // $data = RefProfilDesa::query()->first()->profile_kecamatan;
        // $data = Penduduk::query()->find(3)->tempat_lahir;

        $namaFile = 'catatan.txt';
        $isi = 'Halo, ini adalah isi file teks saya.';




        // membuat folder 
        Storage::disk('public')->makeDirectory('testDir');

        // Menyimpan ke storage/app/public/catatan.txt
        $data = Storage::disk('public')->put($namaFile, $isi);

        $path = 'testing/folder';

        return response()->json([
            'data' => $data,
        ]);
    }
}
