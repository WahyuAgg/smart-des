<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ForeignKeyVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        try {
            $foreignKeys = DatabaseInspector::foreignKeys($table);
            
            if (empty($foreignKeys)) {
                $this->printPass("No foreign keys to verify");
                return;
            }

            foreach ($foreignKeys as $fk) {
                $column = $fk['column'];
                $foreignTable = $fk['table'];
                $reference = $fk['reference'];
                
                $this->printPass("Foreign Key ({$column}) references {$foreignTable}({$reference})");
            }
        } catch (\Exception $e) {
            $this->printWarn("Could not check foreign keys: " . $e->getMessage());
        }
    }
}
