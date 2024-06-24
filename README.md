# :package_slug

## api-app-skeleton

:package_description

## Installation - Package Development (*Current Workflow*)

### From Here - *Child* `Package`

- Navigate to location and install composer dependencies.

  ```sh:
  $ pwd
  /var/www
  $ cd /var/www/packages/:vendor_slug/skeleton 
  $ composer install
  ```

> *During Package DEV*: There may be a need to modify the installer to remove the central dependency of package tools, until context aware include invocation of include.

### From `Backend-API` - *Parent* `Application`

- Modify the *base* `composer.json` and `app.php` configuration files, adding this `VendorName\\Skeleton` Package and `Skeleton\SkeletonServiceProvider`Class.
  - `/composer.json~32-33`

    ```json:/composer.json~32-33
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/",
            "VendorName\\Skeleton\\": "packages/:vendor_slug/:package_slug/src/",
            "VendorName\\Skeleton\\": "packages/:vendor_slug/skeleton/src/"
        }
    },
    ```

  - `/config/app.php~165-166`

    ```php:config/app.php~165-166
    'providers' => ServiceProvider::defaultProviders()->merge([

        /*
         * Package Service Providers...
         * Required for discovery (non auto, as that only applies to the `vendor` dir)
         * while under dev in `Packages`
         */
        VendorName\Skeleton\SkeletonServiceProvider::class,
        VendorName\Skeleton\SkeletonServiceProvider::class,
    ```

- Discover packages, and generate optimized autoload files.

    ```bash
    composer dump-autoload
    ```


  - Publish and run the migrations with:

    ```bash
    php artisan vendor:publish --tag="skeleton-migrations"
    php artisan migrate
    ```

  - Publish the config file with:

    ```bash
    php artisan vendor:publish --tag="skeleton-config"
    ```

  - Publish the (graceful failure html only) views using

    ```bash
    php artisan vendor:publish --tag="skeleton-views"
    ```

- Make sure Vite is running and picks up changes

## ~~Installation~~ - **Post** Development (Composer/Packagist Published)

- Initialize *this* child repository, after modifying the base config above

    ```bash
    composer require packages/:vendor_slug/skeleton
    ```

You can install the package via composer:

```bash
composer require :vendor_slug/skeleton
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="skeleton-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="skeleton-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="skeleton-views"
```

## Usage

```php
$objSkeleton = new VendorName\Skeleton();
echo $objSkeleton->echoPhrase('Hello, VendorName!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [:author_name](https://github.com/:author_username)
- [All Contributors](../../contributors)

## License

Proprietary private software. Please see [License File](LICENSE.md) for more information.

## Stats - *requires hosting/adapter*

*`TODO: CREATE A TOKEN ENABLED WEB HOSTED APP ON CENTRAL DOMAIN TO HANDLE THE INTERNAL REQUESTS FOR ROUTING, ACTIONS, HOOKS, EVENTS, AND STATUS CALLS LIKE THESE`*

[![Latest Version on Packagist](https://img.shields.io/packagist/v/:vendor_slug/backend-login.svg?style=flat-square)](https://packagist.org/packages/:vendor_slug/backend-login)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/:vendor_slug/backend-login/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/:vendor_slug/backend-login/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/:vendor_slug/backend-login/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/:vendor_slug/backend-login/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/:vendor_slug/backend-login.svg?style=flat-square)](https://packagist.org/packages/:vendor_slug/backend-login)
