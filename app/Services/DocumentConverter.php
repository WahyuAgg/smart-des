<?php

namespace App\Services;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentConverter
{
public function docxToPdf(string $docxPath): string
{
    $soffice = env('LIBREOFFICE_PATH');
    // Tentukan folder output yang benar
    $outputDir = storage_path('app/public/generated_surat/pdf');
    File::ensureDirectoryExists($outputDir); // Pastikan folder ada

    $command = sprintf(
        '"%s" --headless --convert-to pdf --outdir "%s" "%s"',
        $soffice,
        $outputDir,
        $docxPath
    );

    exec($command, $output, $result);

    if ($result !== 0) {
        throw new \Exception("Konversi gagal: " . implode("\n", $output));
    }

    // Kembalikan nama file PDF yang benar
    $pdfFilename = pathinfo($docxPath, PATHINFO_FILENAME) . '.pdf';
    return $outputDir . DIRECTORY_SEPARATOR . $pdfFilename;
}
}
