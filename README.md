# Shapin' Calendar

[![Latest Version](https://img.shields.io/github/release/shapintv/calendar.svg?style=flat-square)](https://github.com/shapintv/calendar/releases)
[![Build Status](https://img.shields.io/travis/shapintv/calendar.svg?style=flat-square)](https://travis-ci.org/shapintv/calendar)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/shapintv/calendar.svg?style=flat-square)](https://scrutinizer-ci.com/g/shapintv/calendar)
[![Quality Score](https://img.shields.io/scrutinizer/g/shapintv/calendar.svg?style=flat-square)](https://scrutinizer-ci.com/g/shapintv/calendar)
[![Total Downloads](https://img.shields.io/packagist/dt/shapin/calendar.svg?style=flat-square)](https://packagist.org/packages/shapin/calendar)


## Install

Via Composer

``` bash
$ composer require shapintv/calendar
```

## Usage

Import a ICS file

``` php
$calendar = (new ICSImporter())->import('path/to/calendar.ics');
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
