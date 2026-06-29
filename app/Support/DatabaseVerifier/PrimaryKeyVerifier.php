<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class PrimaryKeyVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        $primaryKey = $model->getKeyName();
        $indexes = DatabaseInspector::indexes($table);

        if (! isset($indexes['PRIMARY'])) {
            $this->printWarn("No PRIMARY index found in table '{$table}'");
            return;
        }

        $primaryColumns = $indexes['PRIMARY']['columns'];

        if (in_array($primaryKey, $primaryColumns)) {
            $this->printPass("Primary key '{$primaryKey}' verified in database");
        } else {
            $this->printFail("Model primary key '{$primaryKey}' does not match database PRIMARY index (" . implode(', ', $primaryColumns) . ")");
        }
    }
}
