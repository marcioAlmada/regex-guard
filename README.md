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
