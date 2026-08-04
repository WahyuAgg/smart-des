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

    }
}