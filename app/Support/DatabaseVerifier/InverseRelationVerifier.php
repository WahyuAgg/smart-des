<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;


class InverseRelationVerifier extends AbstractVerifier
{
    /**
     * Mapping pasangan relasi yang valid.
     */
    protected array $inverseMap = [

        'BelongsTo' => [
            'HasOne',
            'HasMany',
        ],

        'HasOne' => [
            'BelongsTo',
        ],

        'HasMany' => [
            'BelongsTo',
        ],

        'BelongsToMany' => [
            'BelongsToMany',
        ],

        'MorphOne' => [
            'MorphTo',
        ],

        'MorphMany' => [
            'MorphTo',
        ],

        'MorphTo' => [
            'MorphOne',
            'MorphMany',
        ],

        'MorphToMany' => [
            'MorphedByMany',
        ],

        'MorphedByMany' => [
            'MorphToMany',
        ],
    ];

    public function verify(Model $model): void
    {
        $relations = ModelInspector::relations($model);

        foreach ($relations as $relation) {

            $relatedClass = $relation['related'];

            if (! class_exists($relatedClass)) {
                continue;
            }

            $relatedModel = new $relatedClass;

            $inverseRelations = ModelInspector::relations($relatedModel);

            $matched = collect($inverseRelations)
                ->first(function ($inverse) use ($model) {

                    return $inverse['related'] === get_class($model);

                });

            if (! $matched) {

                $this->printWarn(sprintf(
                    "Inverse relation missing : %s::%s()",
                    class_basename($model),
                    $relation['method']
                ));

                continue;
            }

            $expected = $this->inverseMap[$relation['type']] ?? [];

            if (! in_array($matched['type'], $expected)) {

                $this->printFail(sprintf(
                    "%s::%s() ↔ %s::%s() (Expected %s, found %s)",
                    class_basename($model),
                    $relation['method'],
                    class_basename($relatedModel),
                    $matched['method'],
                    implode(' / ', $expected),
                    $matched['type']
                ));

                continue;
            }

            $this->printPass(sprintf(
                "Inverse relation : %s::%s() ↔ %s::%s()",
                class_basename($model),
                $relation['method'],
                class_basename($relatedModel),
                $matched['method']
            ));
        }
    }
}