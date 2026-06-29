<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class DefaultValueVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        $attributes = $model->getAttributes();
        if (empty($attributes)) {
            $this->printPass("No default attributes defined in model");
            return;
        }

        $columns = DatabaseInspector::columns($table);

        foreach ($attributes as $key => $value) {
            if (! isset($columns[$key])) {
                $this->printFail("Default attribute '{$key}' missing in database");
                continue;
            }

            $dbDefault = $columns[$key]['default'];
            
            // MySQL returns string 'NULL' or actual null depending on driver, but usually actual values are strings
            // We just do a loose comparison as strings for basic verification
            if ((string)$dbDefault === (string)$value) {
                $this->printPass("Default value for '{$key}' matches ('{$value}')");
            } else {
                $this->printWarn("Default value mismatch for '{$key}'. Model: '{$value}', Database: '" . ($dbDefault ?? 'null') . "'");
            }
        }
    }
}
