RegexGuard
============

[![Build Status][t-badge]][t-link]
[![Coverage Status][c-badge]][c-link]
[![Scrutinizer Quality Score][s-badge]][s-link]
[![Latest Stable Version][v-badge]][p-link]
[![Total Downloads][d-badge]][p-link]
[![License][l-badge]][p-link]

PHP `preg_` functions do not offer any good way to validate a regular expression. RegexGuard is a wrapper that keeps your API away from malformed regular expressions and uncatchable PCRE compilation warnings.

## Quick Example

First grab a RegexGuard instance:

```php
$guard = \RegexGuard\Factory::getGuard();
```

Validate your regex:

```php

if($guard->isRegexValid($regexp)) {
    // valid
}
else {
    // invalid
}
```

## Composer Installation

```json
{
  "require": {
    "regex-guard/regex-guard": "dev-master"
  }
}
```

Through terminal: `composer require regex-guard/regex-guard:dev-master` :8ball:

## RegexGuard API

##### isRegexValid($pattern);

Validates a given perl compatible regular expression. Returns true when PCRE string is valid, false otherwise:

```php
$guard->isRegexValid('/\w{0,1}/');
// true, regex is valid

$guard->isRegexValid('/\w{1,0}/');
// false, compilation fails: quantifiers are out of order

$guard->isRegexValid('/(\w)(?2)/');
// false, compilation fails: reference to non-existent subpattern at offset 7
```

##### match($pattern, $subject, &$matches = null, $flags = 0, $offset = 0);    

Same as [preg_match](http://php.net/manual/en/function.preg-match.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php

try {
    if($regexGuard->match($pattern, $subject)) {
        // match
    } else {
        // no match
    }
} catch($e \RegexGuard\RegexException) {
    // handle the invalid regexp
}
```

##### matchAll($pattern, $subject, &$matches = null, $flags = PREG_PATTERN_ORDER, $offset = 0);    

Same as [preg_match_all](http://php.net/manual/en/function.preg-match-all.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $found = $regexGuard->matchAll($pattern, $subject, $matches);
    if($found) {
        foreach($matches[0] as $match) {
            //
        }
    }
} catch($e \RegexGuard\RegexException) {
    // handle the invalid regexp
}
```

##### filter($pattern, $subject, $limit = -1, $flags = 0);

Same as [preg_filter](http://php.net/manual/en/function.preg-filter.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $result = $regexGuard->filter($pattern, $subject);
} catch($e \RegexGuard\RegexException) {
    // handle the invalid regexp
}
```

##### grep($pattern, $input, $flags = 0);    

Same as [preg_grep](http://php.net/manual/en/function.preg-grep.php) but throws a `RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $result = $regexGuard->grep($pattern, $input);
} catch($e \RegexGuard\RegexException) {
    // handle the invalid regexp
}
```

##### replace($pattern, $replacement , $subject, $limit = -1, &$count = null);    

Same as [preg_replace](http://php.net/manual/en/function.preg-replace.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $result = $regexGuard->replace($pattern, $replacement, $subject);
} catch($e \RegexGuard\RegexException) {
    // handle the invalid regexp
}
```

##### split($pattern, $subject, $limit = -1, $flags = 0);    

Same as [preg_split](http://php.net/manual/en/function.preg-split.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $list = $regexGuard->split($pattern, $subject);
} catch($e \RegexGuard\RegexException) {
    // handle the invalid regexp
}
```

## Features

- No need for `@preg_match`, `@preg_match_all`... 
- No need to use regexp to validate a given regexp or any other crappy solution
- Aims to be 100% compatible with PHP `preg_*` core functions
- Faster and more reliable than `@` + `preg_*` calls
- Compatible with xdebug.scream

## Contribution Guide
 
0. Fork [regex-guard](https://github.com/marcioAlmada/regex-guard/fork)
0. Clone forked repository
0. Install composer dependencies `$ composer install`
0. Run unit tests `$ phpunit`
0. Modify code: correct bug, implement feature
0. Back to step 4
0. Pull request to master branch

## Copyright

Copyright (c) 2014 Márcio Almada. Distributed under the terms of an MIT-style license. See LICENSE for details.

[t-link]: https://travis-ci.org/marcioAlmada/regex-guard "Travis Build"
[c-link]: https://coveralls.io/r/marcioAlmada/regex-guard?branch=master "Code Coverage"
[s-link]: https://scrutinizer-ci.com/g/marcioAlmada/regex-guard/ "Code Quality"
[p-link]: https://packagist.org/packages/regex-guard/regex-guard "Packagist"

[t-badge]: https://travis-ci.org/marcioAlmada/regex-guard.png?branch=master
[c-badge]: https://coveralls.io/repos/marcioAlmada/regex-guard/badge.png?branch=master
[s-badge]: https://scrutinizer-ci.com/g/marcioAlmada/regex-guard/badges/quality-score.png
[v-badge]: https://poser.pugx.org/regex-guard/regex-guard/v/stable.png
[d-badge]: https://poser.pugx.org/regex-guard/regex-guard/downloads.png
[l-badge]: https://poser.pugx.org/regex-guard/regex-guard/license.png