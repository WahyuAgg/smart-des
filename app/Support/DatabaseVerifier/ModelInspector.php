<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionMethod;

class ModelInspector
{
    public static function table(Model $model): string
    {
        return $model->getTable();
    }

    public static function primaryKey(Model $model): string
    {
        return $model->getKeyName();
    }

    public static function fillable(Model $model): array
    {
        return $model->getFillable();
    }

    public static function casts(Model $model): array
    {
        return $model->getCasts();
    }

    public static function timestamps(Model $model): bool
    {
        return $model->usesTimestamps();
    }

    public static function relations(Model $model): array
    {
        $reflection = new ReflectionClass($model);

        $relations = [];

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {

            if (
                $method->class !== $reflection->getName() ||
                $method->getNumberOfParameters() > 0
            ) {
                continue;
            }

            try {

                $relation = $method->invoke($model);

                if (! $relation instanceof Relation) {
                    continue;
                }

                $foreignKey = null;

                if (method_exists($relation, 'getForeignKeyName')) {
                    $foreignKey = $relation->getForeignKeyName();

                    if (str_contains($foreignKey, '.')) {
                        $foreignKey = explode('.', $foreignKey)[1];
                    }
                }

                $relations[] = [

                    'method' => $method->getName(),

                    'type' => class_basename($relation),

                    'related' => get_class($relation->getRelated()),

                    'foreign_key' => $foreignKey,

                    'owner_key' => method_exists($relation, 'getOwnerKeyName')
                        ? $relation->getOwnerKeyName()
                        : null,

                    'relation' => $relation,

                ];
            } catch (\Throwable) {
                // skip
            }
        }

        return $relations;
    }
}
