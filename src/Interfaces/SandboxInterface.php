<?php

namespace RegexGuard\Interfaces;

interface SandboxInterface
{
    public function __construct(ErrorHandlerInterface $errorHandler);
    public function run(callable $closure, array $args = [], $throwOnError = true, $severity = E_WARNING);
}
