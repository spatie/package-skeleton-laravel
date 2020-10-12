# :package_description

[![Latest Version on Packagist](https://img.shields.io/packagist/v/:vendor_name/:package_name.svg?style=flat-square)](https://packagist.org/packages/:vendor_name/:package_name)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/:vendor_name/:package_name/run-tests?label=tests)](https://github.com/:vendor_name/:package_name/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/:vendor_name/:package_name.svg?style=flat-square)](https://packagist.org/packages/:vendor_name/:package_name)

**Note:** Run `./configure-skeleton` to get started, or manually replace  ```:author_name``` ```:author_username``` ```:author_email``` ```:vendor_name``` ```:package_name``` ```:package_description``` with their correct values in [README.md](README.md), [CHANGELOG.md](CHANGELOG.md), [CONTRIBUTING.md](.github/CONTRIBUTING.md), [LICENSE.md](LICENSE.md) and [composer.json](composer.json) files, then delete this line. You can also run `configure-skeleton.sh` to do this automatically.

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/package-skeleton-laravel.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/package-skeleton-laravel)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require :vendor_name/:package_name
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Spatie\Skeleton\SkeletonServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Spatie\Skeleton\SkeletonServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

``` php
$skeleton = new Spatie\Skeleton();
echo $skeleton->echoPhrase('Hello, Spatie!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [:author_name](https://github.com/:author_username)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
