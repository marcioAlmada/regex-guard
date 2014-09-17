RegexGuard
============

[![Build Status][t-badge]][t-link]
[![Coverage Status][c-badge]][c-link]
[![Scrutinizer Quality Score][s-badge]][s-link]
[![Latest Stable Version][v-badge]][p-link]
[![Total Downloads][d-badge]][p-link]
[![License][l-badge]][p-link]
[![Dependency Status](https://www.versioneye.com/php/regex-guard:regex-guard/1.0.0/badge.svg)](https://www.versioneye.com/php/regex-guard:regex-guard/1.0.0)
[![Reference Status](https://www.versioneye.com/php/regex-guard:regex-guard/reference_badge.svg)](https://www.versioneye.com/php/regex-guard:regex-guard/references)

## Why?

PHP core `preg_*` functions do not offer any good way to validate a regular expression before usage. Some core functions return false for invalid regular expressions but they also emit uncatchable warnings.

**RegexGuard** is a wrapper that allows you to validate regular expressions and keep your API away from uncatchable PCRE compilation warnings.

## Composer Installation

```json
{
  "require": {
    "regex-guard/regex-guard": "~1.0"
  }
}
```

Through terminal: `composer require regex-guard/regex-guard:~1.0` :8ball:

## Quick Example

First grab a **RegexGuard** instance:

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

And there is more...

## RegexGuard API

Internally, **RegexGuard** instance sandboxes all `preg_*` functions calls and handle errors in a convenient way.
All `preg_*` core functions are fully represented:

#### ::isRegexValid($pattern)

Validates a given regexp. Returns true when PCRE string is valid, false otherwise:

```php
$guard->isRegexValid('/\w{0,1}/');
// true, regex is valid

$guard->isRegexValid('/\w{1,0}/');
// false, compilation fails: quantifiers are out of order

$guard->isRegexValid('/(\w)(?2)/');
// false, compilation fails: reference to non-existent subpattern at offset 7
```

#### ::validateRegexOrFail($pattern)

Validates a given regexp or throw `\RegexGuard\RegexException` if PCRE is invalid:

```php
$guard->validateRegexOrFail('/(\w)(?2)/');
// throws: compilation fails: reference to non-existent subpattern at offset 7
```

#### ::match($pattern, $subject, &$matches=null, $flags=0, $offset=0)

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

#### ::matchAll($pattern,$subject,&$matches=null,$flags=?,$offset=0)

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

> NOTE: `$flags` default value depends on your PHP version.

#### ::filter($pattern, $subject, $limit = -1, $flags = 0)

Same as [preg_filter](http://php.net/manual/en/function.preg-filter.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $result = $regexGuard->filter($pattern, $subject);
} catch($e \RegexGuard\RegexException) {
    // handle the invalid regexp
}
```

#### ::grep($pattern, $input, $flags = 0)

Same as [preg_grep](http://php.net/manual/en/function.preg-grep.php) but throws a `RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $result = $regexGuard->grep($pattern, $input);
} catch($e \RegexGuard\RegexException) {
    // handle the invalid regexp
}
```

#### ::replace($pattern, $replace, $subject, $limit=-1, &$count=null)

Same as [preg_replace](http://php.net/manual/en/function.preg-replace.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $result = $regexGuard->replace($pattern, $replacement, $subject);
} catch($e \RegexGuard\RegexException) {
    // handle the invalid regexp
}
```

#### ::split($pattern, $subject, $limit = -1, $flags = 0)

Same as [preg_split](http://php.net/manual/en/function.preg-split.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $list = $regexGuard->split($pattern, $subject);
} catch($e \RegexGuard\RegexException) {
    // handle the invalid regexp
}
```

## Avoiding Exceptions

You can avoid `try catch` blocks by telling **RegexGuard** not to throw exceptions when an invalid regular expression is encountered:

```php
$guard = \RegexGuard\Factory::getGuard()->throwOnException(false);
```

This can be useful to avoid verbosity when your API needs to validate regexp arguments all over the place,
but you will have to be **extra careful** when checking results!

```php                        
if(1 === $guard->match('#foo#y', 'bar')) {
// ^ strict check            ^ bad regex: Unknown modifier 'y' on line 1
}
```

## Manual Instantiation

```php
use RegexGuard\ErrorHandler;
use RegexGuard\Sandbox;
use RegexGuard\RegexGuard;

$guard = new RegexGuard(new Sandbox(new ErrorHandler));
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
