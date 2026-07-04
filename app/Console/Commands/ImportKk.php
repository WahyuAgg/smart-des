<?php

namespace App\Console\Commands;

use App\Imports\KkImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportKk extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'import:kk {file}';

    /**
     * The console command description.
     */
    protected $description = 'Import data KK dari file Excel';

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

        Excel::import(new KkImport, $file);

        $this->info('Import data KK berhasil.');

        return self::SUCCESS;
    }
}