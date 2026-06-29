<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class IndexVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        try {
            $indexes = DatabaseInspector::indexes($table);
            
            if (empty($indexes)) {
                $this->printWarn("No indexes found on table");
                return;
            }

            foreach ($indexes as $name => $index) {
                $columns = implode(', ', $index['columns']);
                $type = $name === 'PRIMARY' ? 'PRIMARY' : ($index['unique'] ? 'UNIQUE' : 'INDEX');
                
                $this->printPass("Index [{$type}] on ({$columns})");
            }
        } catch (\Exception $e) {
            $this->printWarn("Could not check indexes: " . $e->getMessage());
        }
    }
}
