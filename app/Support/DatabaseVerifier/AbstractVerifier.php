<?php

namespace App\Support\DatabaseVerifier;

use App\Console\Commands\VerifyDatabase;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractVerifier implements VerifierInterface
{
    protected VerifyDatabase $command;

    public function __construct(VerifyDatabase $command)
    {
        $this->command = $command;
    }

    abstract public function verify(Model $model): void;

    protected function printPass(string $text): void
    {
        $this->command->printPass($text);
    }

    protected function printFail(string $text): void
    {
        $this->command->printFail($text);
    }

    protected function printWarn(string $text): void
    {
        $this->command->printWarn($text);
    }
}
