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

## Copyright

Copyright (c) 2014 Márcio Almada. Distributed under the terms of an MIT-style license. See LICENSE for details.
