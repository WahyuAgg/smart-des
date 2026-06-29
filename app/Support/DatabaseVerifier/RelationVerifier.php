<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;
use ReflectionMethod;

class RelationVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $reflection = new ReflectionClass($model);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        $checked = false;

        foreach ($methods as $method) {
            if (
                $method->class !== $reflection->getName()
                || $method->isStatic()
                || $method->getNumberOfParameters() > 0
            ) {
                continue;
            }

            try {
                $result = $method->invoke($model);
            } catch (\Throwable) {
                continue;
            }

            if (! $result instanceof Relation) {
                continue;
            }

            $checked = true;
            $relationName = $method->getName();

            if ($result instanceof BelongsTo) {
                $foreignKey = $result->getForeignKeyName();
                if (Schema::hasColumn($model->getTable(), $foreignKey)) {
                    $this->printPass("Relation {$relationName}()");
                } else {
                    $this->printFail("Relation {$relationName}() - missing FK '{$foreignKey}'");
                }
            } elseif ($result instanceof HasMany || $result instanceof HasOne) {
                $related = $result->getRelated();
                $foreignKey = $result->getForeignKeyName();
                if (Schema::hasColumn($related->getTable(), $foreignKey)) {
                    $this->printPass("Relation {$relationName}()");
                } else {
                    $this->printFail("Relation {$relationName}() - '{$foreignKey}' missing in {$related->getTable()}");
                }
            } else {
                $this->printPass("Relation {$relationName}()");
            }
        }

        if (! $checked) {
            $this->printWarn("No relations");
        }
    }
}
