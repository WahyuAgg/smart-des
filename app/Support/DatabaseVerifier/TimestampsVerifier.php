<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class TimestampsVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        $columns = DatabaseInspector::columns($table);

        if ($model->usesTimestamps()) {
            $createdAt = $model->getCreatedAtColumn();
            $updatedAt = $model->getUpdatedAtColumn();

            if (isset($columns[$createdAt])) {
                $this->printPass("Timestamp '{$createdAt}' found");
            } else {
                $this->printFail("Timestamp '{$createdAt}' missing");
            }

            if (isset($columns[$updatedAt])) {
                $this->printPass("Timestamp '{$updatedAt}' found");
            } else {
                $this->printFail("Timestamp '{$updatedAt}' missing");
            }
        } else {
            $this->printWarn("Model does not use timestamps");
        }

        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive($model))) {
            $deletedAt = method_exists($model, 'getDeletedAtColumn') ? $model->getDeletedAtColumn() : 'deleted_at';
            if (isset($columns[$deletedAt])) {
                $this->printPass("SoftDeletes '{$deletedAt}' found");
            } else {
                $this->printFail("SoftDeletes '{$deletedAt}' missing");
            }
        }
    }
}
