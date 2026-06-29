<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;


class CompositeUniqueVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        $indexes = DatabaseInspector::indexes($model->getTable());

        foreach ($indexes as $name => $index) {

            if (!$index['unique']) {
                continue;
            }

            if (count($index['columns']) < 2) {
                continue;
            }

            $this->printPass(
                sprintf(
                    "Composite UNIQUE (%s)",
                    implode(', ', $index['columns'])
                )
            );
        }
    }
}