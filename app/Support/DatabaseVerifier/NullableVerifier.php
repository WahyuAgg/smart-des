<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class NullableVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        try {
            $columns = DatabaseInspector::columns($table);
            
            $nullableCount = 0;
            foreach ($columns as $name => $info) {
                if ($info['nullable']) {
                    $nullableCount++;
                    $this->printPass("Column '{$name}' is Nullable");
                }
            }

            if ($nullableCount === 0) {
                $this->printPass("No nullable columns (all strictly required)");
            }
        } catch (\Exception $e) {
            $this->printWarn("Could not check nullable columns: " . $e->getMessage());
        }
    }
}
