<?php

namespace RegexGuard\Interfaces;

interface RegexRuntimeInterface
{
    public function __construct(SandboxInterface $handler);

    /**
     * Validates a given perl compatible regular expression
     *
     * @param  string                                      $pattern pcre string
     * @return \RegexGuard\Interfaces\RegexHelperInterface
     */
    public function throwOnError($option = true);

    /**
     * Validates a given perl compatible regular expression
     *
     * @param  string  $pattern pcre string
     * @return boolean true when pcre string is valid, false otherwise
     */
    public function isRegexValid($pattern);

    /**
     * Validates a given perl compatible regular expression or throw exception
     *
     * @param  string                    $pattern pcre string
     * @throws \InvalidArgumentException If invalid regexp is given
     */
    public function validateRegexOrFail($pattern);

    /**
     * Same as \preg_filter but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-filter.php
     */
    public function filter($pattern, $subject, $limit = -1, $flags = 0);
    /**
     * Same as \preg_grep but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-grep.php
     */
    public function grep($pattern, $input, $flags = 0);

    /**
     * Same as \preg_match but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-match.php
     */
    public function match($pattern, $subject, &$matches = null, $flags = 0, $offset = 0);
    /**
     * Same as \preg_match but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-match-all.php
     */
    public function matchAll($pattern, $subject, &$matches = null, $flags = PREG_PATTERN_ORDER, $offset = 0);

    /**
     * Same as \preg_replace but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-replace.php
     */
    public function replace($pattern, $replacement , $subject, $limit = -1, &$count = null);

    /**
     * Same as \preg_split but throws exception when an invalid pcre string is given
     *
     * @link http://php.net/manual/en/function.preg-split.php
     */
    public function split($pattern, $subject, $limit = -1, $flags = 0);

}
