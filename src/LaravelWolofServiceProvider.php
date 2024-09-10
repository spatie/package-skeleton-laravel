<?php

namespace IdrissaNdiouck\LaravelWolof;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use IdrissaNdiouck\LaravelWolof\Commands\LaravelWolofCommand;

class LaravelWolofServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-wolof')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_wolof_table')
            ->hasCommand(LaravelWolofCommand::class);
    }
}
