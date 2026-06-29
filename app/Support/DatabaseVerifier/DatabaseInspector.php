<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class DatabaseInspector
{
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
            ->map(fn ($row) => [
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
     * Semua kolom beserta nullable.
     */
    public static function columns(string $table): array
    {
        $rows = DB::select("
            SELECT
                COLUMN_NAME,
                IS_NULLABLE,
                DATA_TYPE
            FROM information_schema.COLUMNS
            WHERE
                TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = ?
        ", [$table]);

        return collect($rows)
            ->mapWithKeys(fn ($row) => [
                $row->COLUMN_NAME => [
                    'nullable' => $row->IS_NULLABLE === 'YES',
                    'type' => $row->DATA_TYPE,
                ]
            ])
            ->toArray();
    }
}