<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class SuratController extends Controller
{
    /**
     * Generate surat DOCX dari template.
     */
    public function generate(Request $request)
    {
        $templatePath = storage_path('app/templates/domisili_temp.docx');

        if (! file_exists($templatePath)) {
            abort(404, 'Template surat tidak ditemukan.');
        }

        $template = new TemplateProcessor($templatePath);

        // Contoh data (nanti diganti dari database)
        $data = [
            'nomor'        => '470/001/VII/2026',
            'nama'         => 'Budi Santoso',
            'nik'          => '3306123456789012',
            'alamat'       => 'Desa Curug',
            'kepala_desa'  => 'Sutrisno',
        ];

        foreach ($data as $key => $value) {
            $template->setValue($key, $value);
        }

        $fileName = 'Surat_' . now()->format('YmdHis') . '.docx';

        $outputPath = storage_path("app/generated/{$fileName}");

        if (! is_dir(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        $template->saveAs($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend();
    }
}