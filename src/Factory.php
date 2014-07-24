<?php

namespace RegexGuard;

/**
 * RegexGuard facade
 *
 */
abstract class Factory
{
    final public static function getGuard()
    {
        return new RegexGuard(new Sandbox(new ErrorHandler));
    }
}
