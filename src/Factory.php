<?php

namespace RegexGuard;

use RegexGuard\RegexGuard;
use RegexGuard\Sandbox;
use RegexGuard\ErrorHandler;

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