<?php

namespace RegexGuard;

/**
 * RegexGuardTest
 *
 */
class RegexGuardTest extends \PHPUnit_Framework_TestCase
{
    protected $runtime;

    public function setUp()
    {
        $this->guard = Factory::getGuard();
    }

    public function testRegexValidation()
    {
        $this->assertTrue ($this->guard->isRegexValid('#\(#'));
        $this->assertFalse($this->guard->isRegexValid('#(#'));

        $this->assertTrue($this->guard->isRegexValid('#(\[)#'));
        $this->assertFalse($this->guard->isRegexValid('#([)#'));

        $this->assertTrue($this->guard->isRegexValid('##i'));
        $this->assertFalse($this->guard->isRegexValid('##y'));

        $this->assertTrue ($this->guard->isRegexValid('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/'));
        $this->assertFalse(
            $this->guard->isRegexValid('/^(\d{1,0}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/')
            //                                  ^ Compilation failed: numbers out of order in {} quantifier at offset 7
        );
    }

    /**
     * @expectedException \RegexGuard\RegexException
     * @dataProvider invalidRegexProviders
     */
    public function testValidateRegexOrFail($pattern, $message)
    {
        $this->expectRegexException($message);
        $this->guard->validateRegexOrFail($pattern);
    }

    /**
     * @expectedException \RegexGuard\RegexException
     * @dataProvider invalidRegexProviders
     */
    public function testValidateRegexOrFailWithThrowDisabled($pattern, $message)
    {
        $this->expectRegexException($message);
        $this->guard->throwOnError(false);
        $this->guard->validateRegexOrFail($pattern);
    }

    public function testMatch()
    {
        $pattern = '#[a-z]#';
        $this->assertEquals(0, $this->guard->match($pattern, '@10123456789'));

        $this->assertEquals(1, $this->guard->match($pattern, 'regexguard'));

        $this->guard->match($pattern, 'regexguard', $match);
        $this->assertEquals(['r'], $match);

        $this->guard->match($pattern, 'regexguard', $match, PREG_OFFSET_CAPTURE);
        $this->assertEquals([['r', 0]], $match);

        $this->guard->match($pattern, 'regexguard', $match, PREG_OFFSET_CAPTURE, 1);
        $this->assertEquals([['e', 1]], $match);

        $this->guard->match($pattern, 'regexguard', $match, PREG_OFFSET_CAPTURE, 4);
        $this->assertEquals([['x', 4]], $match);

        $this->guard->match($pattern, 'regexguard', $match, PREG_OFFSET_CAPTURE, 9);
        $this->assertEquals([['d', 9]], $match);
    }

    /**
     * @dataProvider invalidRegexProviders
     */
    public function testMatchRegexException($pattern, $message)
    {
        $this->expectRegexException($message);
        $this->guard->match($pattern, '');
    }

    public function testMatchAll()
    {
        $pattern = '#\d|([a-z])#';
        $this->assertSame(preg_match_all($pattern, 'a1b2c3d4e5'), $this->guard->matchAll($pattern, 'a1b2c3d4e5'));

        preg_match_all($pattern, 'a1b2c3d4e5', $x);
        $this->guard->matchAll($pattern, 'a1b2c3d4e5', $y);
        $this->assertSame($x, $y);

        unset($x, $y);

        preg_match_all($pattern, 'a1b2c3d4e5', $x, PREG_PATTERN_ORDER, 8);
        $this->guard->matchAll($pattern, 'a1b2c3d4e5', $y, PREG_PATTERN_ORDER, 8);
        $this->assertSame($x, $y);
    }

    /**
     * @dataProvider invalidRegexProviders
     */
    public function testMatchAllRegexException($pattern, $message)
    {
        $this->expectRegexException($message);
        $this->guard->matchAll($pattern, '');
    }

    public function testGrep()
    {
        $values = ['a', 1, 'b', 2, 'c', 3, 'd', 4, 'e', 5];
        $this->assertEquals(preg_grep('#[[:digit:]]#', $values), $this->guard->grep('#[[:digit:]]#', $values));
        $this->assertEquals(
            preg_grep          ('#[[:alpha:]]#', $values, PREG_GREP_INVERT),
            $this->guard->grep('#[[:alpha:]]#', $values, PREG_GREP_INVERT)
        );
    }

    /**
     * @dataProvider invalidRegexProviders
     */
    public function testGrepRegexException($pattern, $message)
    {
        $this->expectRegexException($message);
        $this->guard->grep($pattern, []);
    }

    /**
     * @expectedException \RegexGuard\RegexException
     * @expectedExceptionMessage grep() expects parameter 2 to be array, string given
     */
    public function testGrepExceptionOnInvalidArguments()
    {
        $this->skipHHVM();

        $this->guard->grep('##', '');
    }

    public function testReplace()
    {
        $string = 'April 15, 2003';
        $pattern = '/(\w+) (\d+), (\d+)/i';
        $replacement = '${1}1,$3';
        $this->assertEquals(
            preg_replace($pattern, $replacement, $string),
            $this->guard->replace($pattern, $replacement, $string)
        );
    }

    /**
     * @dataProvider invalidRegexProviders
     */
    public function testReplaceRegexException($pattern, $message)
    {
        $this->expectRegexException($message);
        $this->guard->replace($pattern, '', '');
    }

    public function testSplit()
    {
        $pattern = '#\w#';
        $subject = 'abcdefgh';

        $this->assertEquals(
            preg_split($pattern, $subject),
            $this->guard->split($pattern, $subject)
        );

        $this->assertEquals(
            preg_split($pattern, $subject, 10),
            $this->guard->split($pattern, $subject, 10)
        );

        $this->assertEquals(
            preg_split($pattern, $subject, 10, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_OFFSET_CAPTURE),
            $this->guard->split($pattern, $subject, 10, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_OFFSET_CAPTURE)
        );
    }

    /**
     * @dataProvider invalidRegexProviders
     */
    public function testSplitRegexException($pattern, $message)
    {
        $this->expectRegexException($message);
        $this->guard->split($pattern, '');
    }

    public function testFilter()
    {
        $this->skipHHVM();

        $subject = ['1', 'a', '2', 'b', '3', 'A', 'B', '4'];
        $pattern = ['/\d/', '/[a-z]/', '/[1a]/'];
        $replace = ['A:$0', 'B:$0', 'C:$0'];

        $this->assertEquals(
            preg_filter($pattern, $replace, $subject),
            $this->guard->filter($pattern, $replace, $subject)
        );

        $this->assertEquals(
            preg_filter($pattern, $replace, $subject),
            $this->guard->filter($pattern, $replace, $subject)
        );
    }

    /**
     * @dataProvider invalidRegexProviders
     */
    public function testFilterRegexException($pattern, $message)
    {
        $this->skipHHVM();
        $this->expectRegexException($message);

        $this->guard->filter($pattern, '', '');
    }

    /**
     * @dataProvider invalidRegexProviders
     */
    public function testBehaviorWhenExceptionsAreDisabled($pattern)
    {
        $this->guard->throwOnError(false);

        $this->assertFalse($this->guard->isRegexValid($pattern));

        $this->assertFalse($this->guard->match($pattern, ''));

        $this->assertFalse($this->guard->matchAll($pattern, '', $matches));
        $this->assertNull($matches);

        $this->assertFalse($this->guard->matchAll($pattern, '', $matches));

        $this->assertFalse($this->guard->grep($pattern, []));

        $this->assertNull($this->guard->replace($pattern, '', ''));
        $this->assertSame([], $this->guard->replace([$pattern], [''], ['a', 'b']));

        $this->assertFalse($this->guard->filter($pattern, ['a'], ['a', 'b']));
        $this->assertEquals([], $this->guard->filter([$pattern], ['a'], ['a', 'b']));

        $this->assertFalse($this->guard->split($pattern, ''));

    }

    /**
     * @requires extension xdebug
     */
    public function testWithXdebugScreamEnabled()
    {
        ini_set('xdebug.scream', '1');
        $this->assertFalse($this->guard->throwOnError(false)->match('#', ''));
    }

    public function invalidRegexProviders()
    {
        return [
            ['/\\/', 'No ending delimiter \'/\' found'],
            ['\w/', 'Delimiter must not be alphanumeric or backslash'],
            ['#\w', 'No ending delimiter \'#\' found'],
            ['\w#', 'Delimiter must not be alphanumeric or backslash'],
            ['##y', 'Unknown modifier \'y\''],
            ['##z', 'Unknown modifier \'z\''],
            ['#((())))#', 'Compilation failed: unmatched parentheses at offset 6'],
            ['#[a-@]]#', 'Compilation failed: range out of order in character class at offset 3'],
            ['#\w{1,0}#', 'Compilation failed: numbers out of order in {} quantifier at offset 6'],
            ['#(?1)#', 'Compilation failed: reference to non-existent subpattern at offset 3'],
            ['#(\w)(?2)#', 'Compilation failed: reference to non-existent subpattern at offset 7'],
        ];
    }

    protected function expectRegexException($message)
    {
        $this->setExpectedException('\RegexGuard\RegexException', $message);
    }

    protected function skipHHVM()
    {
        if(defined('HHVM_VERSION')) $this->markTestSkipped();
    }
}
