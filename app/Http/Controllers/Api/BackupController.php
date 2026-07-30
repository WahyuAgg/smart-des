<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use RuntimeException;

class BackupController extends ApiController
{
    /**
     * Create a backup of the application.
     * Includes: storage/app files, SQL dump, and .env file.
     */
    public function backup(): JsonResponse
    {
        try {
            $timestamp = now()->format('Y-m-d_H-i-s');
            $backupDir = storage_path('backups');
            $backupFilename = "backup_{$timestamp}.zip";
            $backupPath = "{$backupDir}/{$backupFilename}";

            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            $zip = new ZipArchive();
            if ($zip->open($backupPath, ZipArchive::CREATE) !== true) {
                throw new RuntimeException('Gagal membuat file zip.');
            }

            // 1. Add storage/app contents
            $this->addFolderToZip($zip, storage_path('app'), 'storage/app');

            // 2. Add .env file
            $envPath = base_path('.env');
            if (file_exists($envPath)) {
                $zip->addFile($envPath, '.env');
            }

            // 3. Add SQL dump — write to temp file first, then add to zip
            $sqlDumpFile = tempnam(sys_get_temp_dir(), 'sql_dump_zip_');
            $this->writeSqlDumpToFile($sqlDumpFile);
            $zip->addFile($sqlDumpFile, 'database.sql');

            $zip->close();

            // Clean up temp SQL dump file
            @unlink($sqlDumpFile);

            // Delete old backups, keep only the last 5
            $this->cleanOldBackups($backupDir, 5);

            return $this->success(
                [
                    'filename' => $backupFilename,
                    'path' => "backups/{$backupFilename}",
                    'size' => round(filesize($backupPath) / 1024 / 1024, 2) . ' MB',
                    'created_at' => $timestamp,
                ],
                'Backup berhasil dibuat.',
                201
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal membuat backup: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Download the latest backup file.
     */
    public function download(): mixed
    {
        try {
            $backupDir = storage_path('backups');

            if (!is_dir($backupDir)) {
                return $this->error('Belum ada backup tersedia.', null, 404);
            }

            $files = glob($backupDir . '/backup_*.zip');
            if (empty($files)) {
                return $this->error('Belum ada backup tersedia.', null, 404);
            }

            // Sort by modified time, newest first
            usort($files, fn($a, $b) => filemtime($b) - filemtime($a));

            $latestBackup = $files[0];
            $filename = basename($latestBackup);

            return response()->download($latestBackup, $filename);
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal mengunduh backup: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Recursively add a folder and its contents to the zip archive,
     * while respecting .gitignore rules.
     */
    private function addFolderToZip(ZipArchive $zip, string $folderPath, string $zipPrefix): void
    {
        $folderPath = rtrim($folderPath, '/\\');
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folderPath, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            /** @var \SplFileInfo $item */
            // Get the relative path from the folder root
            $relativePath = $zipPrefix . '/' . substr($item->getPathname(), strlen($folderPath) + 1);
            $relativePath = str_replace('\\', '/', $relativePath);

            // Skip the backups directory itself to avoid infinite recursion
            if (str_starts_with($relativePath, 'storage/app/backups/') || str_starts_with($relativePath, 'storage/app/backups')) {
                continue;
            }

            if ($item->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else {
                // Skip .gitignore files
                if ($item->getBasename() === '.gitignore') {
                    continue;
                }
                $zip->addFile($item->getPathname(), $relativePath);
            }
        }
    }

    /**
     * Write SQL dump to a file.
     * Uses mysqldump if available, otherwise falls back to PHP-based chunked dump.
     */
    private function writeSqlDumpToFile(string $filePath): void
    {
        $dbHost = config('database.connections.mysql.host');
        $dbPort = config('database.connections.mysql.port');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');

        // Try using mysqldump with output redirected to the file
        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s %s %s > %s 2>&1',
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbUser),
            !empty($dbPass) ? '--password=' . escapeshellarg($dbPass) : '',
            escapeshellarg($dbName),
            escapeshellarg($filePath)
        );

        $returnCode = null;
        exec($command, $_, $returnCode);

        if ($returnCode === 0 && filesize($filePath) > 0) {
            return;
        }

        // Fallback: use PHP-based dump with chunked processing
        @unlink($filePath);
        $this->writePhpSqlDumpToFile($filePath);
    }

    /**
     * PHP-based SQL dump using chunked queries, writing directly to a file.
     */
    private function writePhpSqlDumpToFile(string $filePath): void
    {
        $handle = fopen($filePath, 'w');

        if (!$handle) {
            throw new RuntimeException('Gagal membuat file temporary untuk SQL dump.');
        }

        $dbName = config('database.connections.mysql.database');
        $tables = DB::select('SHOW TABLES');
        $keyName = 'Tables_in_' . $dbName;

        foreach ($tables as $table) {
            $tableName = $table->{$keyName};

            // Get CREATE TABLE
            $createStmt = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $createCol = 'Create Table';
            fwrite($handle, "\n\n" . $createStmt[0]->{$createCol} . ";\n\n");

            // Get data in chunks to avoid memory exhaustion
            DB::table($tableName)->orderBy(DB::raw('IFNULL(NULL, 1)'))->chunk(200, function ($rows) use ($handle, $tableName) {
                foreach ($rows as $row) {
                    $row = (array) $row;
                    $columns = array_keys($row);
                    $values = array_map(function ($val) {
                        if (is_null($val)) {
                            return 'NULL';
                        }
                        return "'" . str_replace(["'", "\\"], ["\\'", "\\\\"], $val) . "'";
                    }, array_values($row));

                    fwrite($handle, "INSERT INTO `{$tableName}` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n");
                }
            });
        }

        fclose($handle);
    }

    /**
     * Clean old backup files, keeping only the latest N.
     */
    private function cleanOldBackups(string $backupDir, int $keep = 5): void
    {
        $files = glob($backupDir . '/backup_*.zip');
        if (count($files) <= $keep) {
            return;
        }

        // Sort by modified time, oldest first
        usort($files, fn($a, $b) => filemtime($a) - filemtime($b));

        $toDelete = array_slice($files, 0, count($files) - $keep);
        foreach ($toDelete as $file) {
            @unlink($file);
        }
    }

    public function downloadSqlite()
    {
        return response()->download(
            database_path('database.sqlite'),
            'smartdes-' . now()->format('Y-m-d_H-i-s') . '.sqlite'
        );
    }
}
