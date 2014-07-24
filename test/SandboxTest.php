<?php

namespace RegexGuard;

use Mockery as M;

/**
 * SandboxTest
 *
 */
class SandboxTest extends \PHPUnit_Framework_TestCase
{

    protected $sandbox;

    public function tearDown()
    {
        M::close();
    }

    public function setUp()
    {
        $this->sandbox = new Sandbox(new ErrorHandler());
    }

    public function testRuntimeWithErrorHandlerIntegration()
    {
        $handler = M::mock('\RegexGuard\Interfaces\ErrorHandlerInterface')
                      ->shouldReceive('enable')->times(1)
                      ->shouldReceive('disable')->times(1)
                      ->getMock();

        $this->sandbox = new Sandbox($handler);
        $this->sandbox->run(function () {});
    }

    /**
     * @dataProvider badSandboxCallProvider
     */
    public function testDefaultRuntime(callable $closure, array $args = [])
    {
        $spy = M::mock('\stdClass')->shouldReceive('checkpoint')->times(3)->getMock();
        $this->assertFalse($this->sandbox->run($closure, $args, false));

        try {
            $spy->checkpoint();
            $this->sandbox->run($closure, $args);
            $spy->checkpoint();
        } catch (RegexException $e) {
            $spy->checkpoint();
            $this->assertFalse($this->sandbox->run($closure, $args, false));
            $spy->checkpoint();
        }

        $this->assertFalse($this->sandbox->run($closure, $args, false));
    }

    /**
     * @dataProvider badSandboxCallProvider
     */
    public function testDefaultRuntimeIsolation(callable $closure, array $args = [])
    {
        $spy = M::mock('\stdClass')->shouldReceive('checkpoint')->times(2)->with('signal')->getMock();

        set_error_handler(function ($errno, $errstr) use ($spy) {
            $spy->checkpoint($errstr);
        }, E_USER_WARNING);

        trigger_error('signal', E_USER_WARNING);

        $this->sandbox = new Sandbox(new ErrorHandler());
        $this->assertFalse($this->sandbox->run($closure, $args, false));

        trigger_error('signal', E_USER_WARNING);
    }

    public function badSandboxCallProvider()
    {
        return [
            [function () { return preg_match('#', ''); }],
            ['preg_match', ['#', '']],
        ];
    }

}
