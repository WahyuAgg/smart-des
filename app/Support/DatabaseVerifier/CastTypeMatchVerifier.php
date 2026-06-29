<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class CastTypeMatchVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        $columns = DatabaseInspector::columns($table);
        $castError = false;

        foreach ($model->getCasts() as $column => $castType) {
            if (in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                continue;
            }
            
            // Skip enum casts, handled by EnumVerifier
            if (class_exists($castType) && enum_exists($castType)) {
                continue;
            }

            if (! isset($columns[$column])) {
                $this->printWarn("Cast '{$column}' not found in database");
                $castError = true;
                continue;
            }

            $dbType = strtolower($columns[$column]['type']);
            
            $match = $this->checkTypeMatch($castType, $dbType);

            if ($match) {
                $this->printPass("Cast '{$column}' ({$castType}) matches DB type ({$dbType})");
            } else {
                $this->printFail("Cast '{$column}' ({$castType}) DOES NOT match DB type ({$dbType})");
                $castError = true;
            }
        }

        if (! $castError && count($model->getCasts()) > 0) {
            $this->printPass("All primitive casts match DB types");
        }
    }

    protected function checkTypeMatch(string $castType, string $dbType): bool
    {
        $castType = strtolower(trim(explode(':', $castType)[0])); // handle decimal:2 etc
        
        switch ($castType) {
            case 'int':
            case 'integer':
                return in_array($dbType, ['int', 'tinyint', 'smallint', 'mediumint', 'bigint']);
            case 'real':
            case 'float':
            case 'double':
                return in_array($dbType, ['float', 'double', 'decimal']);
            case 'decimal':
                return $dbType === 'decimal';
            case 'string':
                return in_array($dbType, ['varchar', 'char', 'text', 'mediumtext', 'longtext']);
            case 'bool':
            case 'boolean':
                return in_array($dbType, ['tinyint', 'bool', 'boolean']);
            case 'object':
            case 'array':
            case 'json':
            case 'collection':
                return in_array($dbType, ['json', 'text', 'longtext']);
            case 'date':
            case 'datetime':
            case 'timestamp':
                return in_array($dbType, ['date', 'datetime', 'timestamp']);
            default:
                // We'll be lenient for unknown casts like 'hashed' or custom cast classes
                return true; 
        }
    }
}
