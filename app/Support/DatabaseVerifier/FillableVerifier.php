<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class FillableVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        $columns = Schema::getColumnListing($table);
        $fillableError = false;

        foreach ($model->getFillable() as $column) {
            if (! in_array($column, $columns)) {
                $this->printFail("Fillable '{$column}' not found");
                $fillableError = true;
            }
        }

        if (! $fillableError && !empty($model->getFillable())) {
            $this->printPass("Fillable");
        }
    }
}
