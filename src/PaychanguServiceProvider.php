<?php

namespace Paychangu\Laravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PaychanguServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('paychangu')
            ->hasConfigFile();
    }

    public function packageRegistered()
    {
        $this->app->singleton('paychangu', function ($app) {
            // Paychangu constructor is now defensive and handles missing config gracefully
            // This allows the package to be uninstalled without errors
            return new Paychangu;
        });
    }
}
