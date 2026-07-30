<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use RuntimeException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;
use STS\ZipStream\Facades\Zip;

class BackupController extends ApiController
{
    
    public function downloadBackupFiles()
    
    {
        $basePath = storage_path('app');

        $zip = Zip::create(
            'backup-' . now()->format('Y-m-d_H-i-s') . '.zip'
        );

        $directories = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $basePath,
                FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {

            $relativePath = str_replace(
                DIRECTORY_SEPARATOR,
                '/',
                substr($item->getPathname(), strlen($basePath) + 1)
            );

            if ($item->isDir()) {

                if (!isset($directories[$relativePath])) {
                    $zip->addDirectory($relativePath);
                    $directories[$relativePath] = true;
                }

                continue;
            }

            $zip->add(
                $item->getPathname(),
                $relativePath
            );
        }

        return $zip;
    }



    public function downloadBackupSqlite()
    {
        return response()->download(
            database_path('database.sqlite'),
            'smartdes-' . now()->format('Y-m-d_H-i-s') . '.sqlite'
        );
    }
}
