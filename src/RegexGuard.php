<?php

namespace RegexGuard;

use RegexGuard\Interfaces\RegexRuntimeInterface;
use RegexGuard\Interfaces\SandboxInterface;

class RegexGuard implements RegexRuntimeInterface
{
    protected $sandbox;

    /**
     * Wether exception should be thrown when invalid regex is given
     *
     * @var boolean
     */
    protected $throw = true;

    public function __construct(SandboxInterface $sandbox)
    {
        $this->sandbox = $sandbox;
    }

    /**
     * Wether exception should be thrown when invalid regex is given
     *
     * @param  boolean                 $option
     * @return \RegexGuard\RegexHelper self
     */
    public function throwOnError($option = true)
    {
        $this->throw = (bool) $option;

        return $this;
    }

    /**
     * Validates a given pcre string
     *
     * @param  string  $pattern pcre string
     * @return boolean true when pcre string is valid, false otherwise
     */
    public function isRegexValid($pattern)
    {
        return false !== $this->sandbox->run('preg_match', [$pattern, ''], false);
    }

    /**
     * Validates a given perl compatible regular expression or throw exception
     *
     * @param  string                    $pattern pcre string
     * @throws \InvalidArgumentException If invalid regexp is given
     */
    public function validateRegexOrFail($pattern)
    {
        $this->sandbox->run('preg_match', [$pattern, '']);
    }

    /**
     * Same as \preg_filter but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-filter.php
     */
    public function filter($pattern, $subject, $limit = -1, $flags = 0)
    {
        return $this->sandbox->run('preg_filter', func_get_args(), $this->throw);
    }

    /**
     * Same as \preg_grep but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-grep.php
     */
    public function grep($pattern, $input, $flags = 0)
    {
        return $this->sandbox->run('preg_grep', func_get_args(), $this->throw);
    }

    /**
     * Same as \preg_match but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-match.php
     */
    public function match($pattern, $subject, &$matches = null, $flags = 0, $offset = 0)
    {
        return $this->sandbox->run('preg_match', [$pattern, $subject, &$matches, $flags, $offset], $this->throw);
    }

    /**
     * Same as \preg_match_all but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-match-all.php
     */
    public function matchAll($pattern, $subject, &$matches = null, $flags = PREG_PATTERN_ORDER, $offset = 0)
    {
        return $this->sandbox->run('preg_match_all', [$pattern, $subject, &$matches, $flags, $offset], $this->throw);
    }

    /**
     * Same as \preg_replace but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-replace.php
     */
    public function replace($pattern, $replacement , $subject, $limit = -1, &$count = null)
    {
        return $this->sandbox->run('preg_replace', func_get_args(), $this->throw);
    }

    /**
     * Same as \preg_split but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-split.php
     */
    public function split($pattern, $subject, $limit = -1, $flags = 0)
    {
        return $this->sandbox->run('preg_split', func_get_args(), $this->throw);
    }

}
