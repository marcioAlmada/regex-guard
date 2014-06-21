<?php

namespace RegexGuard\Interfaces;

interface ErrorHandlerInterface
{
    public function enable($throwOnError, $severity);
    public function disable();
}
