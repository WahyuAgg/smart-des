<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use ReflectionEnum;

class EnumVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        $casts = $model->getCasts();
        $columns = DatabaseInspector::columns($table);
        $enumCount = 0;

        foreach ($casts as $column => $castType) {
            if (class_exists($castType) && enum_exists($castType)) {
                $enumCount++;
                if (! isset($columns[$column])) {
                    $this->printFail("Enum column '{$column}' missing in database");
                    continue;
                }

                $columnType = strtolower($columns[$column]['column_type']); // e.g. enum('a','b')

                if (! str_starts_with($columnType, 'enum(')) {
                    $this->printFail("Column '{$column}' is not an ENUM in database (is {$columnType})");
                    continue;
                }

                // Extract values from enum('a','b')
                preg_match("/^enum\((.*)\)$/", $columnType, $matches);
                if (! isset($matches[1])) {
                    $this->printFail("Could not parse ENUM values for '{$column}'");
                    continue;
                }

                $dbEnumValues = array_map(function($val) {
                    return trim($val, "'");
                }, explode(',', $matches[1]));

                // Get PHP Enum cases
                $reflection = new ReflectionEnum($castType);
                $phpEnumValues = array_map(function($case) {
                    return $case->getBackingValue();
                }, $reflection->getCases());

                $missingInDb = array_diff($phpEnumValues, $dbEnumValues);
                $extraInDb = array_diff($dbEnumValues, $phpEnumValues);

                if (empty($missingInDb) && empty($extraInDb)) {
                    $this->printPass("Enum '{$column}' matches database perfectly");
                } else {
                    if (! empty($missingInDb)) {
                        $this->printFail("Enum '{$column}': Missing in DB: " . implode(', ', $missingInDb));
                    }
                    if (! empty($extraInDb)) {
                        $this->printWarn("Enum '{$column}': Extra in DB: " . implode(', ', $extraInDb));
                    }
                }
            }
        }

        if ($enumCount === 0) {
            $this->printPass("No PHP Enums defined in casts");
        }
    }
}
