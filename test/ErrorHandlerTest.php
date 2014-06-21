<?php

namespace RegexGuard;

/**
 * ErrorHandlerTest
 * 
 */
class ErrorHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $handler = new ErrorHandler;
        $stack = $handler->enable();
        $this->assertFalse($handler->enable());
        $this->assertTrue($handler->disable());
        $this->assertFalse($handler->disable());
        $this->assertSame($stack, $handler->enable());
    }
}
