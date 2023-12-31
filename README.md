# Laravel API Generator With Resources

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dolar/laravel-api-generator.svg?style=flat-square)](https://packagist.org/packages/dolar/laravel-api-generator)
[![Build Status](https://img.shields.io/travis/dolar/laravel-api-generator/master.svg?style=flat-square)](https://travis-ci.org/dolar/laravel-api-generator)
[![Quality Score](https://img.shields.io/scrutinizer/g/dolar/laravel-api-generator.svg?style=flat-square)](https://scrutinizer-ci.com/g/dolar/laravel-api-generator)
[![Total Downloads](https://img.shields.io/packagist/dt/dolar/laravel-api-generator.svg?style=flat-square)](https://packagist.org/packages/dolar/laravel-api-generator)
[![StyleCI](https://github.styleci.io/repos/218828115/shield?branch=master)](https://github.styleci.io/repos/218828115)

This package is used to generate laravel api with Resources

## Installation

You can install the package via composer:

```bash
composer require dolar/laravel-crud-api-generator
```

## Publish Configuration File

```bash
php artisan vendor:publish --provider="Dolar\LaravelApiGenerator\LaravelApiGeneratorServiceProvider" --tag="config"

Next, if you plan for cross origin support, you should add middleware to your api middleware group within your app/Http/Kernel.php file:
'ApiHeaderInject'

add in env
for allow cross origin support
API_ALLOW_CROSS_ORIGIN = true
for json content type
API_JSON_RESPONSE = true
```

## Usage

``` php
php artisan api:generate --model=User
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email morsheddolar1990@gmail.com instead of using the issue tracker.

## Credits

- [Motakabbir Morshed](https://github.com/Motakabbir)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
