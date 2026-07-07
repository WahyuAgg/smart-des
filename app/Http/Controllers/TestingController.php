<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\RefPerangkatDesa;
use App\Models\RefProfilDesa;

use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function testing(){
        // $data = RefProfilDesa::query()->first()->profile_kecamatan;
        $data = Penduduk::query()->find(3)->tempat_lahir;

        return response()->json([
            'data'=> $data
        ]);

    }

    
}
