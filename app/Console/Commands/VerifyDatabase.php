<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;
use ReflectionMethod;

class VerifyDatabase extends Command
{
    protected $signature = 'db:verify';

    protected $description = 'Verify Eloquent models against database schema';

    protected int $errors = 0;
    protected int $warnings = 0;

    public function handle(): int
    {
        $files = File::allFiles(app_path('Models'));

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

            //--------------------------------------------------
            // TABLE
            //--------------------------------------------------

            if (! Schema::hasTable($table)) {

                $this->printFail("Table exists");

                continue;
            }

            $this->printPass("Table exists");

            $columns = Schema::getColumnListing($table);

            //--------------------------------------------------
            // FILLABLE
            //--------------------------------------------------

            $fillableError = false;

            foreach ($model->getFillable() as $column) {

                if (! in_array($column, $columns)) {

                    $this->printFail("Fillable '{$column}' not found");

                    $fillableError = true;
                }
            }

            if (! $fillableError) {

                $this->printPass("Fillable");
            }

            //--------------------------------------------------
            // CASTS
            //--------------------------------------------------

            $castError = false;

            foreach (array_keys($model->getCasts()) as $column) {

                if (in_array($column, [
                    'id',
                    'created_at',
                    'updated_at',
                ])) {
                    continue;
                }

                if (! in_array($column, $columns)) {

                    $this->warnStep("Cast '{$column}' not found");

                    $castError = true;
                }
            }

            if (! $castError) {

                $this->printPass("Casts");
            }

            //--------------------------------------------------
            // RELATIONS
            //--------------------------------------------------

            $this->verifyRelations($model);
        }

        $this->newLine();
        $this->line(str_repeat('═', 60));

        $this->info("Verification finished");

        $this->line("Errors   : {$this->errors}");
        $this->line("Warnings : {$this->warnings}");

        $this->line(str_repeat('═', 60));

        return self::SUCCESS;
    }

    protected function verifyRelations(Model $model): void
    {
        $reflection = new ReflectionClass($model);

        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $checked = false;

        foreach ($methods as $method) {

            if (
                $method->class !== $reflection->getName()
                || $method->isStatic()
                || $method->getNumberOfParameters() > 0
            ) {
                continue;
            }

            try {

                $result = $method->invoke($model);

            } catch (\Throwable) {

                continue;
            }

            if (! $result instanceof Relation) {
                continue;
            }

            $checked = true;

            //--------------------------------------------------
            // BelongsTo
            //--------------------------------------------------

            if ($result instanceof BelongsTo) {

                $foreignKey = $result->getForeignKeyName();

                if (Schema::hasColumn($model->getTable(), $foreignKey)) {

                    $this->printPass("Relation {$method->getName()}()");

                } else {

                    $this->printFail("Relation {$method->getName()}() - missing FK '{$foreignKey}'");
                }
            }

            //--------------------------------------------------
            // HasMany / HasOne
            //--------------------------------------------------

            elseif ($result instanceof HasMany || $result instanceof HasOne) {

                $related = $result->getRelated();

                $foreignKey = $result->getForeignKeyName();

                if (Schema::hasColumn($related->getTable(), $foreignKey)) {

                    $this->printPass("Relation {$method->getName()}()");

                } else {

                    $this->printFail(
                        "Relation {$method->getName()}() - '{$foreignKey}' missing in {$related->getTable()}"
                    );
                }
            }

            //--------------------------------------------------
            // Other relation
            //--------------------------------------------------

            else {

                $this->printPass("Relation {$method->getName()}()");
            }
        }

        if (! $checked) {

            $this->warnStep("No relations");
        }
    }

    //--------------------------------------------------
    // Helpers
    //--------------------------------------------------

protected function printPass(string $text): void
{
    $this->info("  ✔ {$text}");
}

protected function printFail(string $text): void
{
    $this->errors++;

    $this->error("  ✖ {$text}");
}

protected function printWarn(string $text): void
{
    $this->warnings++;

    $this->warn("  ⚠ {$text}");
}
}