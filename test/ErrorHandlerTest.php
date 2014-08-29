<?php

namespace RegexGuard;

/**
 * ErrorHandlerTest
 *
 */
class ErrorHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testStack()
    {
        $handler = new ErrorHandler;
        $stack = $handler->enable();
        $this->assertFalse($handler->enable());
        $this->assertTrue($handler->disable());
        $this->assertFalse($handler->disable());
        $this->assertSame($stack, $handler->enable());
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage signal b
     */
    public function testAutoDefuse()
    {
        $handler = new ErrorHandler;
        $stack = $handler->enable(true, E_USER_WARNING);

        try {
            trigger_error('signal a', E_USER_WARNING);
        } catch (RegexException $e) {
            $this->assertContains('signal a', $e->getMessage());
            trigger_error('signal b', E_USER_WARNING);
        }
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage signal c
     */
    public function testWithThowOnWarningOff()
    {
        $handler = new ErrorHandler;
        $stack = $handler->enable(false, E_USER_WARNING);

        trigger_error('signal a', E_USER_WARNING);
        trigger_error('signal b', E_USER_WARNING);

        $handler->disable();

        trigger_error('signal c', E_USER_WARNING);
    }
}
