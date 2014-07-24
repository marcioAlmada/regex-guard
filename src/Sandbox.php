<?php

namespace RegexGuard;

use RegexGuard\Interfaces\SandboxInterface;
use RegexGuard\Interfaces\ErrorHandlerInterface;

class Sandbox implements SandboxInterface
{
    protected $errorHandler;

    public function __construct(ErrorHandlerInterface $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function run(callable $closure, array $args = [], $throwOnError = true, $severity = E_WARNING)
    {
        $this->errorHandler->enable($throwOnError, $severity);
        $result = call_user_func_array($closure, $args);
        $this->errorHandler->disable();

        return $result;
    }
}
