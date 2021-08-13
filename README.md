# A simple ecommerce solution for Laravel apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wearefar/laravel-ecommerce.svg?style=flat-square)](https://packagist.org/packages/wearefar/laravel-ecommerce)
[![Total Downloads](https://img.shields.io/packagist/dt/wearefar/laravel-ecommerce.svg?style=flat-square)](https://packagist.org/packages/wearefar/laravel-ecommerce)

A Laravel package to build a simple ecommerce.

## Installation

You can install the package via composer:

```bash
composer require wearefar/laravel-ecommerce
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="WeAreFar\Ecommerce\EcommerceServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="WeAreFar\Ecommerce\EcommerceServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
// WIP
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you've found a bug regarding security please mail [victor@wearefar.com](mailto:victor@wearefar.com) instead of using the issue tracker.

## Credits

- [Victor Guerrero](https://github.com/vguerrerobosch)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
