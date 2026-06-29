<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Support\Facades\Schema;


use Illuminate\Support\Facades\DB;

class DatabaseInspector
{
    public static function tableExists(string $table): bool
    {
        return Schema::hasTable($table);
    }

    public static function uniqueIndexes(string $table): array
    {
        return collect(self::indexes($table))
            ->filter(fn($index) => $index['unique'])
            ->toArray();
    }

    public static function compositeUniqueIndexes(string $table): array
    {
        return collect(self::uniqueIndexes($table))
            ->filter(fn($index) => count($index['columns']) > 1)
            ->values()
            ->toArray();
    }

    public static function nullableColumns(string $table): array
    {
        return collect(self::columns($table))
            ->filter(fn($column) => $column['nullable'])
            ->keys()
            ->toArray();
    }

    public static function defaultValues(string $table): array
    {
        return collect(self::columns($table))
            ->mapWithKeys(fn($column, $name) => [
                $name => $column['default']
            ])
            ->toArray();
    }

    public static function foreignKeyActions(string $table): array
    {
        $rows = DB::select("
    SELECT
        kcu.COLUMN_NAME,
        kcu.REFERENCED_TABLE_NAME,
        kcu.REFERENCED_COLUMN_NAME,
        rc.UPDATE_RULE,
        rc.DELETE_RULE
    FROM information_schema.REFERENTIAL_CONSTRAINTS rc
    JOIN information_schema.KEY_COLUMN_USAGE kcu
        ON rc.CONSTRAINT_NAME = kcu.CONSTRAINT_NAME
        AND rc.CONSTRAINT_SCHEMA = kcu.CONSTRAINT_SCHEMA
    WHERE
        rc.CONSTRAINT_SCHEMA = DATABASE()
        AND kcu.TABLE_NAME = ?
", [$table]);

        return collect($rows)
            ->map(fn($row) => [
                'column' => $row->COLUMN_NAME,
                'table' => $row->REFERENCED_TABLE_NAME,
                'reference' => $row->REFERENCED_COLUMN_NAME,
                'on_update' => strtoupper($row->UPDATE_RULE),
                'on_delete' => strtoupper($row->DELETE_RULE),
            ])
            ->toArray();
    }

    /**
     * Semua foreign key pada tabel.
     */

    public static function foreignKeys(string $table): array
    {
        $rows = DB::select("
            SELECT
                COLUMN_NAME,
                REFERENCED_TABLE_NAME,
                REFERENCED_COLUMN_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE
                TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = ?
                AND REFERENCED_TABLE_NAME IS NOT NULL
        ", [$table]);

        return collect($rows)
            ->map(fn($row) => [
                'column' => $row->COLUMN_NAME,
                'table' => $row->REFERENCED_TABLE_NAME,
                'reference' => $row->REFERENCED_COLUMN_NAME,
            ])
            ->toArray();
    }

    /**
     * Semua index pada tabel.
     */
    public static function indexes(string $table): array
    {
        $rows = DB::select("
            SELECT
                INDEX_NAME,
                COLUMN_NAME,
                NON_UNIQUE
            FROM information_schema.STATISTICS
            WHERE
                TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = ?
            ORDER BY INDEX_NAME
        ", [$table]);

        return collect($rows)
            ->groupBy('INDEX_NAME')
            ->map(function ($group) {
                return [
                    'unique' => $group->first()->NON_UNIQUE == 0,
                    'columns' => collect($group)
                        ->pluck('COLUMN_NAME')
                        ->values()
                        ->toArray(),
                ];
            })
            ->toArray();
    }

    /**
     * Semua kolom beserta detail tipe dan default.
     */
    public static function columns(string $table): array
    {
        $rows = DB::select("
            SELECT
                COLUMN_NAME,
                IS_NULLABLE,
                DATA_TYPE,
                COLUMN_TYPE,
                COLUMN_DEFAULT
            FROM information_schema.COLUMNS
            WHERE
                TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = ?
        ", [$table]);

        return collect($rows)
            ->mapWithKeys(fn($row) => [
                $row->COLUMN_NAME => [
                    'nullable' => $row->IS_NULLABLE === 'YES',
                    'type' => $row->DATA_TYPE,
                    'column_type' => $row->COLUMN_TYPE,
                    'default' => $row->COLUMN_DEFAULT,
                ]
            ])
            ->toArray();
    }
}
