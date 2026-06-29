<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ForeignKeyActionVerifier extends AbstractVerifier
{
    public function verify(Model $model): void
    {
        foreach (DatabaseInspector::foreignKeyActions($model->getTable()) as $fk) {

            $this->printPass(
                sprintf(
                    "FK Action (%s): DELETE=%s UPDATE=%s",
                    $fk['column'],
                    $fk['on_delete'],
                    $fk['on_update']
                )
            );
        }
    }
}