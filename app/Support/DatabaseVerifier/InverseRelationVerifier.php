<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;

class InverseRelationVerifier extends AbstractVerifier
{
    /**
     * Namespace model yang akan diverifikasi.
     * Model vendor/package akan diabaikan.
     */
    protected array $allowedNamespaces = [
        'App\\Models\\',
    ];

    /**
     * Pasangan relasi yang valid.
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

            if (! $this->shouldVerifyRelation($relatedClass)) {
                continue;
            }

            /** @var Model $relatedModel */
            $relatedModel = new $relatedClass;

            $inverseRelations = ModelInspector::relations($relatedModel);

            $matched = collect($inverseRelations)
                ->first(function ($inverse) use ($model, $relation) {

                    // Harus mengarah kembali ke model asal
                    if ($inverse['related'] !== get_class($model)) {
                        return false;
                    }

                    // Jika kedua relasi punya foreign key,
                    // pastikan FK sama (menghindari false positive
                    // ketika ada lebih dari satu relasi ke model yang sama)
                    if (
                        ! empty($relation['foreign_key']) &&
                        ! empty($inverse['foreign_key'])
                    ) {
                        return $relation['foreign_key'] === $inverse['foreign_key'];
                    }

                    return true;
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

            if (! in_array($matched['type'], $expected, true)) {

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

    /**
     * Menentukan apakah relasi perlu diverifikasi.
     */
    protected function shouldVerifyRelation(string $relatedClass): bool
    {
        if (! class_exists($relatedClass)) {
            return false;
        }

        foreach ($this->allowedNamespaces as $namespace) {

            if (str_starts_with($relatedClass, $namespace)) {
                return true;
            }
        }

        return false;
    }
}