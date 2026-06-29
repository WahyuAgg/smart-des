<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class CastVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        $columns = Schema::getColumnListing($table);
        $castError = false;

        foreach (array_keys($model->getCasts()) as $column) {
            if (in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                continue;
            }

            if (! in_array($column, $columns)) {
                $this->printWarn("Cast '{$column}' not found in database");
                $castError = true;
            }
        }

        if (! $castError && count($model->getCasts()) > 0) {
            $this->printPass("Casts");
        }
    }
}
