<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\RefPerangkatDesa;
use App\Models\RefProfilDesa;

use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function testKades(){
        // $data = RefProfilDesa::query()->first()->profile_kecamatan;
        $data = Penduduk::query()->first()->umur;

        return response()->json([
            'data'=> $data
        ]);

    }

    
}
