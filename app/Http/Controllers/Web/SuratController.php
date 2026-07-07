<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SuratService;

class SuratController extends Controller
{
    public function getTemplates()
    {
        $steps = [
            'Pilih Surat',
            'Isi NIK',
            'Isi Form',
            'Preview',
            'Cetak',
        ];
        return view('surat.surat-wizard', [
            'currentStep' => 'pilih-surat',
            'noStep' => 1,
            'steps' => $steps
        ]);
    }
}
