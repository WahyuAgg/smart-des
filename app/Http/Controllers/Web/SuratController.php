<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SuratService;

class SuratController extends Controller
{
    public function getTemplates()
    {


        return view('surat.index', [
        ]);
    }
}
