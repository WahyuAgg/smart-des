<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use App\Support\DatabaseVerifier\TableVerifier;
use App\Support\DatabaseVerifier\FillableVerifier;
use App\Support\DatabaseVerifier\CastVerifier;
use App\Support\DatabaseVerifier\RelationVerifier;
use App\Support\DatabaseVerifier\ForeignKeyVerifier;
use App\Support\DatabaseVerifier\IndexVerifier;
use App\Support\DatabaseVerifier\NullableVerifier;
use App\Support\DatabaseInspector;

class VerifyDatabase extends Command
{
    protected $signature = 'db:verify';

    protected $description = 'Verify Eloquent models against database schema';

    protected int $errors = 0;
    protected int $warnings = 0;

    public function handle(): int
    {
        $files = File::allFiles(app_path('Models'));

        $verifiers = [
            new TableVerifier($this),
            new FillableVerifier($this),
            new CastVerifier($this),
            new RelationVerifier($this),
            new ForeignKeyVerifier($this),
            new IndexVerifier($this),
            new NullableVerifier($this),
        ];

        foreach ($files as $file) {

            $class = 'App\\Models\\' . $file->getFilenameWithoutExtension();

            if (! class_exists($class)) {
                continue;
            }

            /** @var Model $model */
            $model = new $class;

            $table = $model->getTable();

            $this->newLine();
            $this->line(str_repeat('─', 60));

            $this->info("Model : {$class}");
            $this->line("Table : {$table}");
            $this->newLine();

            foreach ($verifiers as $verifier) {
                $verifier->verify($model);
            }
        }

        $this->newLine();
        $this->line(str_repeat('═', 60));

        $this->info("Verification finished");

        $this->line("Errors   : {$this->errors}");
        $this->line("Warnings : {$this->warnings}");

        $this->line(str_repeat('═', 60));

        return self::SUCCESS;
    }

    public function printPass(string $text): void
    {
        $this->info("  ✔ {$text}");
    }

    public function printFail(string $text): void
    {
        $this->errors++;
        $this->error("  ✖ {$text}");
    }

    public function printWarn(string $text): void
    {
        $this->warnings++;
        $this->warn("  ⚠ {$text}");
    }
}