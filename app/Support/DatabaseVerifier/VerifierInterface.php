<?php

namespace App\Support\DatabaseVerifier;

use Illuminate\Database\Eloquent\Model;

interface VerifierInterface
{
    public function verify(Model $model): void;
}
