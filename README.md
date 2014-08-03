RegexGuard
============

[![Build Status][t-badge]][t-link]
[![Coverage Status][c-badge]][c-link]
[![Scrutinizer Quality Score][s-badge]][s-link]
[![Latest Stable Version][v-badge]][p-link]
[![Total Downloads][d-badge]][p-link]
[![License][l-badge]][p-link]

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

> That's awkward but php doesn't offer any good way to validate a regular expression. There is no core function like `preg_validate_reger`, some core functions may return false on PCRE compilation errors but they also emit uncatchable warnings.

RegexGuard is a wrapper that keeps your API away from malformed regular expressions and uncatchable PCRE compilation warnings. Quick example:

```php

class MyFooClass
{
    /**
     * Apply filter using a regular expression
     *
     * @param  string $regexp Must be a valid regexp (PCRE) string
     */
    public function filter($regexp)
    {
        $guard = \RegexGuard\Factory::getGuard(); // grab guard instance

        if($guard->isRegexValid($regexp)) {
            // regexp is a valid regular expression, proceed :)
        } else {
            // handle the invalid argument!
        }
    }
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

## API

### RegexGuard::isRegexValid(\$pattern);

Validates a given perl compatible regular expression. Returns true when PCRE string is valid, false otherwise:

```php
$guard = \RegexGuard\Factory::getGuard();

$guard->isRegexValid('/\w{0,1}/');  // true, regex is valid
$guard->isRegexValid('/\w{1,0}/');  // false, compilation fails: quantifiers are out of order
$guard->isRegexValid('/(\w)(?2)/'); // false, compilation fails: reference to non-existent subpattern at offset 7
```

### RegexGuard::match(\$pattern, \$subject, &\$matches = null, \$flags = 0, \$offset = 0);    

Same as [preg_match](http://php.net/manual/en/function.preg-match.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    if(\RegexGuard\Factory::getGuard()->match($pattern, $subject)) {
        // match
    } else {
        // no match
    }
} catch($e \RegexGuard\RegexException) {
    // invalid regexp given
}
```

### RegexGuard::matchAll(\$pattern, \$subject, &\$matches = null, \$flags = PREG_PATTERN_ORDER, \$offset = 0);    

Same as [preg_match_all](http://php.net/manual/en/function.preg-match-all.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $found = \RegexGuard\Factory::getGuard()->matchAll($pattern, $subject, $matches);
    if($found) {
        foreach($matches[0] as $match) {
            ...
        }
    }
} catch($e \RegexGuard\RegexException) {
    // invalid regexp given
}
```

### RegexGuard::filter(\$pattern, \$subject, \$limit = -1, \$flags = 0);

Same as [preg_filter](http://php.net/manual/en/function.preg-filter.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $result = \RegexGuard\Factory::getGuard()->filter($pattern, $subject);
} catch($e \RegexGuard\RegexException) {
    // invalid regexp given
}
```

### RegexGuard::grep(\$pattern, \$input, \$flags = 0);    

Same as [preg_grep](http://php.net/manual/en/function.preg-grep.php) but throws a `RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $result = \RegexGuard\Factory::getGuard()->grep($pattern, $input);
} catch($e \RegexGuard\RegexException) {
    // invalid regexp given
}
```

### RegexGuard::replace(\$pattern, \$replacement , \$subject, \$limit = -1, &\$count = null);    

Same as [preg_replace](http://php.net/manual/en/function.preg-replace.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $result = \RegexGuard\Factory::getGuard()->replace($pattern, $replacement, $subject);
} catch($e \RegexGuard\RegexException) {
    // invalid regexp given
}
```

### RegexGuard::split(\$pattern, \$subject, \$limit = -1, \$flags = 0);    

Same as [preg_split](http://php.net/manual/en/function.preg-split.php) but throws a `\RegexGuard\RegexException` when an invalid PCRE string is given:

```php
try {
    $list = \RegexGuard\Factory::getGuard()->split($pattern, $subject);
} catch($e \RegexGuard\RegexException) {
    // invalid regexp given
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
