PsySH Hoa\Consle
================

[PsySH](http://psysh.org/) with pure PHP readline support from [Hoa\Console](https://github.com/hoaproject/Console).

## Notice

**This project will be abandoned in the future (after `psy/psysh` next major release).**

You can use this package in `psy/psysh:0.7.2` or *earlier*.

This code is integrated into PsySH. ([Pull Request #300 · bobthecow/psysh](https://github.com/bobthecow/psysh/pull/300) is merged.)

## Setup

### Composer

Get [Composer](https://getcomposer.org/).

### Global Install

`composer require global require zonuexe/psysh-hoa-console`

### Project REPL

`cd /path/to/your/project; composer require zonuexe/psysh-hoa-console`

Put snippet into your private REPL code.

```php
use Psy\Readline\GNUReadline;
use Psy\Readline\Libedit;
use zonuexe\Psy\Readline\HoaConsoleAdapter;

$is_dumb = !isset($_ENV['TERM']) || ($_ENV['TERM'] === 'dumb');
$config = new \Psy\Configuration;

if (!$is_dump && !GNUReadline::isSupported() && !Libedit::isSupported()) {
    $config->setReadline(new HoaConsoleAdapter);
}

$sh = new \Psy\Shell($config);
$sh->run();
```

See [PHPを「シェル化」する [psy/psysh] - 超PHPerになろう](http://cho-phper.hateblo.jp/entry/2015/11/10/031000) (in Japanese)

## Copyright

This Source Code Form is subject to the terms of the Mozilla Public License, v. 2.0. If a copy of the MPL was not distributed with this file, You can obtain one at https://mozilla.org/MPL/2.0/.

> PsySH Hoa\Consle - Interactive shell using pure PHP readline
> (c) copyright 2016 USAMI Kenta
