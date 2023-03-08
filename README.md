
# Generate favicon files for Laravel.

[![Version](https://img.shields.io/packagist/v/chrisjk123/laravel-favicon.svg?include_prereleases&style=flat&label=packagist)](https://packagist.org/packages/chrisjk123/laravel-favicon)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)
![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/chrisjk123/laravel-favicon/run-tests?style=flat&label=tests)

## Installation

You can install the package via composer:

```bash
composer require chrisjk123/laravel-favicon
```

You can optionally publish the config file with:

```bash
php artisan vendor:publish --provider="Chriscreates\Favicon\Providers\FaviconServiceProvider" --tag="favicon-config"
```

## Usage

```bash
php aritsan favicon:generate
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

If you discover any security related issues, please email christopherjk123@gmail.com instead of using the issue tracker.

## Credits

- [Christopher Kelker](https://github.com/chrisjk123)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
