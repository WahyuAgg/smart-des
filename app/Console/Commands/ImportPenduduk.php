<?php

namespace App\Console\Commands;

use App\Imports\PendudukImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportPenduduk extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'import:penduduk {file : Path file Excel (.xlsx, .xls, .csv)}';

    /**
     * The console command description.
     */
    protected $description = 'Import data penduduk dari file Excel';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $file = $this->argument('file');

        if (! file_exists($file)) {
            $this->error("File tidak ditemukan: {$file}");

            return self::FAILURE;
        }

        $this->info('Memulai import penduduk...');

        try {
            Excel::import(new PendudukImport(), $file);

            $this->newLine();
            $this->info('======================================');
            $this->info('Import penduduk berhasil.');
            $this->info('======================================');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->newLine();
            $this->error('Import gagal.');
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}