<?php

namespace Mzati\Paychangu;

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
            return new Paychangu();
        });
    }
}
